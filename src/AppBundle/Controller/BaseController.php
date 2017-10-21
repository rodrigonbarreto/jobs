<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BaseController
 * @package AppBundle\Controller
 */
class BaseController extends Controller
{

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected function getEntityManager()
    {
        $em = $this->getDoctrine()->getManager();
        return $em;
    }

    /**
     * @return Job[]|array
     */
    protected function getAllJobs()
    {
        $em = $this->getEntityManager();
      return  $em->getRepository(Job::class)->findAll();
    }

    protected function removeEntity($obj)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($obj);
        $em->flush();
    }
}
