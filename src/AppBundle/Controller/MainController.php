<?php

namespace AppBundle\Controller;

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