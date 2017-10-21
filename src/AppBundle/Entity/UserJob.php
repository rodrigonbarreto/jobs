<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * UserJob
 *
 * @ORM\Entity
 * @ORM\Table(name="user_job")
 * @UniqueEntity(
 *     fields={"job", "user"},
 *     message="This user is already interested in this job",
 *     errorPath="job"
 * )
 */
class UserJob
{
    use TimestampableEntity;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = true;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userJobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="jobUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $job;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return UserJob
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return UserJob
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set job
     *
     * @param Job $job
     *
     * @return UserJob
     */
    public function setJob(Job $job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }
}
