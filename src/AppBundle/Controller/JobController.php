<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Form\JobType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JobController
 * @package AppBundle\Controller
 * @Route("job")
 *
 */
class JobController extends BaseController
{
    /**
     * Lists all job entities.
     *
     * @Route("/", name="job_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $jobs = $this->getEntityManager()->getRepository(Job::class)->findAll();

        return $this->render('job/index.html.twig', array(
            'jobs' => $jobs,
        ));
    }

    /**
     * Finds and displays a job entity.
     * Everybody Can see details about JOB
     *
     * @Route("/{slug}", name="job_show")
     * @Method("GET")
     *
     * @param Job $job
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Job $job)
    {

        return $this->render('job/show.html.twig', array(
            'job' => $job
        ));
    }
}
