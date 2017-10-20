<?php

namespace AppBundle\Admin;

use AppBundle\Enum\RolesEnum;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * Class UserAdmin
 * @package AppBundle\Admin
 */
class UserAdmin extends AbstractAdmin
{

    protected $formOptions = ['validation_groups' => 'reg'];

    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->id($this->getSubject())) {

            $this->formOptions = [];

        } else {
            $this->formOptions = ['validation_groups' => 'Registration'];
        }

        $formMapper->add('roles', 'json_array');
        $formMapper->add('jobs', 'sonata_type_collection', array(
            'by_reference' => false,
        ), array(
            'edit' => 'inline',
            'inline' => 'table',
            'sortable' => 'id',
            'link_parameters' => array('owner-id' => $this->getSubject()->getId()),
        ));

        $formMapper->add('email', EmailType::class);
        $formMapper->add('firstName');
        $formMapper->add('lastName');
        $formMapper->add('roles','choice', array('choices' => RolesEnum::ELEMENTS, 'multiple'=>true ));
        $formMapper->add('plainPassword', 'password', array('required' => false));

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('email');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', null, ['label' => 'ID']);
        $listMapper->addIdentifier('email');
    }
}