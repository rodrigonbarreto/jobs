<?php

namespace AppBundle\Service;

use AppBundle\Entity\Job;
use AppBundle\Entity\User;
use AppBundle\Entity\UserJob;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserJobService
 * @package AppBundle\Service
 */
class UserJobService
{
    /** @var  ValidatorInterface $validator */
    protected $validator;

    /** @var  $userJob */
    protected $userJob;
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * UserJobService constructor.
     * @param ValidatorInterface $validator
     * @param UserJob $userJob
     * @param EntityManager $manager
     */
    public function __construct
    (
        ValidatorInterface $validator,
        UserJob $userJob,
        EntityManager $manager
    ){
        $this->validator = $validator;
        $this->userJob = $userJob;
        $this->manager = $manager;
    }

    /**
     * @param Job $job
     * @param User $user
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function checkValidate(Job $job, User $user)
    {
        $this->userJob->setJob($job);
        $this->userJob->setUser($user);
        $errors = $this->validator->validate($this->userJob);

        return $errors;
    }

    /**
     * Add Interest For User
     */
    public function saveUserJobInterest()
    {
        $this->manager->persist($this->userJob);
        $this->manager->flush();
    }

    /**
     * @param UserJob $userJob
     */
    public function removeUserJobInterest(UserJob $userJob)
    {
        $this->manager->remove($userJob);
        $this->manager->flush();
    }
}
