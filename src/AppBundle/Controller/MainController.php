<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Job;
use AppBundle\Entity\User;
use AppBundle\Entity\UserJob;

/**
 * Class MainController
 * @package AppBundle\Controller
 */
class MainController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepageAction()
    {
        $jobs = $jobs = $this->getAllJobs();

        return $this->render('main/homepage.html.twig',
            ['jobs' => $jobs]
        );

    }
}