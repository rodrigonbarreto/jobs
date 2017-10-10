<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\BaseController;
use AppBundle\Entity\Job;
use AppBundle\Form\Admin\JobTypeAdmin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JobAdminController
 * @package AppBundle\Controller\Admin
 * @Route("/job-admin")
 */
class JobAdminController extends BaseController
{
    /**
     * Lists all job entities.
     *
     * @Route("/", name="job_admin_index")
     * @Method("GET")
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $jobs = $this->getAllJobs();

        return $this->render('/admin/job/index.html.twig', array(
            'jobs' => $jobs,
        ));
    }

    /**
     * Creates a new job entity.
     *
     * @Route("/new", name="job_admin_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $job = new Job();
        $form = $this->createForm(JobTypeAdmin::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Job $job */
            $job = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('job_admin_index', array('slug' => $job->getSlug())) ;
        }

        return $this->render('/admin/job/new.html.twig', array(
            'job' => $job,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing job entity.
     *
     * @Route("/{slug}/edit", name="job_admin_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Job $job
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        $editForm = $this->createForm(JobTypeAdmin::class, $job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "uhul job updated");
            return $this->redirectToRoute('job_admin_index', array('slug' => $job->getSlug()));
        }

        return $this->render('admin/job/edit.html.twig', array(
            'job' => $job,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a job entity.
     *
     * @Route("/{id}", name="job_admin_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Job $job
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Job $job)
    {
        $form = $this->createDeleteForm($job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();
        }

        return $this->redirectToRoute('job_admin_index');
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
            ->setAction($this->generateUrl('job_admin_delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
