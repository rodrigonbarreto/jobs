<?php

namespace AppBundle\Entity;
use AppBundle\Repository\UserJobRepository;
use AppBundle\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"email"}, message="It looks like you already have an account!")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * The encoded password
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * A non-persisted field that's used to create the encoded password.
     * @Assert\NotBlank(groups={"Registration"})
     *
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserJob", mappedBy="user")
     */
    private $userJobs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userJobs = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        // leaving blank
    }

    /**
     * Erase credentials
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Return full Name firstName + LastName
     *
     * @return string
     */
    public function getFullName()
    {
        return trim($this->getFirstName().' '.$this->getLastName());
    }

    /**
     * Add userJob
     *
     * @param UserJob $userJob
     *
     * @return User
     */
    public function addUserJob(UserJob $userJob)
    {
        $this->userJobs[] = $userJob;

        return $this;
    }

    /**
     * Remove userJob
     *
     * @param UserJob $userJob
     */
    public function removeUserJob(UserJob $userJob)
    {
        $this->userJobs->removeElement($userJob);
    }

    /**
     * Get userJobs
     *
     * @return \Doctrine\Common\Collections\Collection|UserJob[]
     */
    public function getUserJobs()
    {
        return $this->userJobs;
    }

    /**
     * @param $job
     * @return bool
     */
    public function checkConcern($job)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('job', $job))
            ->setMaxResults(1);

        $results = $this->userJobs->matching($criteria);

        return $results->count() ? true : false;
    }
}
