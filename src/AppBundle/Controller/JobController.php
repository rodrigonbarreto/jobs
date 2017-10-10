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
 * @Security("has_role('ROLE_USER')")
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
        $jobs = $this->getEntityManager()->getRepository(Job::class)->getJobsByUser($this->getUser());

        return $this->render('job/index.html.twig', array(
            'jobs' => $jobs,
        ));
    }

    /**
     * Creates a new job entity.
     *
     * @Route("/new", name="job_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @Security("has_role('ROLE_USER')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $job = new Job();
        $form = $this->createForm(JobType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Job $job */
            $job = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('job_show', array('slug' => $job->getSlug())) ;
        }

        return $this->render('job/new.html.twig', array(
            'job' => $job,
            'form' => $form->createView(),
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
        $deleteForm = $this->createDeleteForm($job);

        return $this->render('job/show.html.twig', array(
            'job' => $job,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing job entity.
     *
     * @Route("/{slug}/edit", name="job_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Job $job
     *
     * @Security("has_role('ROLE_USER')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Job $job)
    {
        $isOwner = $this->checkOwnerJob($job);

        if ($isOwner) {
            $this->addFlash('error', "You don't have permission for this JOB");
            return $this->redirectToRoute('job_index');
        }

        $deleteForm = $this->createDeleteForm($job);
        $editForm = $this->createForm(JobType::class, $job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "uhul job updated");
            return $this->redirectToRoute('job_edit', array('slug' => $job->getSlug()));
        }

        return $this->render('job/edit.html.twig', array(
            'job' => $job,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a job entity.
     *
     * @Route("/{id}", name="job_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Job $job
     *
     * @Security("has_role('ROLE_USER')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Job $job)
    {
        $isOwner = $this->checkOwnerJob($job);

        if ($isOwner) {
            $this->addFlash('error', "You don't have permission for this JOB");
            return $this->redirectToRoute('job_index');
        }

        $form = $this->createDeleteForm($job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();
        }

        return $this->redirectToRoute('job_index');
    }

    /**
     * Creates a form to delete a job entity.
     *
     * @param Job $job The job entity
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('job_delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @param Job $job
     * @return bool
     */
    private function checkOwnerJob(Job $job) {
        if ($this->getUser()->getId() !== $job->getUpdatedBy()) {
            return false;
        }
        return true;
    }
}
