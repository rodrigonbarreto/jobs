<?php

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class JobAdmin
 * @package AppBundle\Admin
 */
class JobAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', 'text');
        $formMapper->add('description', 'textarea');
        $formMapper->add('createdBy', 'entity', [
            'choice_label' => 'email',
            'class' => User::class,
            'label' => 'form.user.email',
        ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', null, ['label' => 'ID']);
        $listMapper->addIdentifier('title');
    }
}