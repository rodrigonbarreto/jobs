<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Entity\User;
use AppBundle\Entity\UserJob;
use AppBundle\Service\UserJobService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Class JobInterestController
 * @package AppBundle\Controller
 * @Route("job-interest")
 *
 * @Security("has_role('ROLE_USER')")
 */
class JobInterestController extends BaseController
{
    /**
     * Lists all job entities.
     *
     * @Route("/{job}/add-interest", name="job_add_interest")
     * @Method("GET")
     * @param UserJobService     $userJobService
     * @param Job                $job

     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addInterestAction(Job $job, UserJobService $userJobService)
    {
        $errors = $userJobService->checkValidate($job, $this->getUser());
        if ($errors->count() > 0) {
            $this->addFlash('error', "You already show Interest for this job");
            return $this->redirectToRoute('job_show', ['slug' => $job->getSlug()]);
        } else {
            $this->addFlash('success', "Good Uhul");
            $userJobService->saveUserJobInterest();
            return $this->redirectToRoute('job_show', ['slug' => $job->getSlug()]);
        }
    }

    /**
     * Lists all job entities.
     *
     * @Route("/{job}/remove-interest", name="job_remove_interest")
     * @Method("GET")
     *
     * @param Job $job
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeInterestAction(Job $job, UserJobService $userJobService )
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->checkConcern($job)) {

            $userJob = $this->getEntityManager()->getRepository(UserJob::class)
                ->findOneBy(['user' => $user, 'job' => $job]);
            $userJobService->removeUserJobInterest($userJob);

            $this->addFlash('error', "NOOOO do not give up!!");
            return $this->redirectToRoute('job_show', ['slug' => $job->getSlug()]);
        }

//        return $this->redirectToRoute('job_show', ['slug' => $job->getSlug()]);
    }
}
