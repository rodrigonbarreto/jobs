<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;
use Tests\AbstractFunctionalTest;

/**
 * Class JobControllerTest
 * @package AppBundle\Tests\Controller
 *
 * @group functional
 */
class JobControllerTest extends AbstractFunctionalTest
{
    /**
     * @test
     *
     */
    public function loginAction()
    {
        $this->submitLogin();
    }


    /**
     * Login in main page
     */
    private function submitLogin()
    {
        $loginUrl = '/login';
        $crawler = $this->getClient()->request('GET', $loginUrl);
        $this->assertEquals(Response::HTTP_OK, $this->getClient()->getResponse()->getStatusCode(), $loginUrl);

        $form = $crawler->selectButton('Login')->form(array(
            'login_form[_username]'  => 'user_2@gmail.com',
            'login_form[_password]'  => '123123',
        ));

        $this->getClient()->submit($form);
    }
}
