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
     * @dataProvider newActionDataProvider
     *
     * @param array $fieldsJob
     */
    public function newAction($fieldsJob)
    {
        $this->submitLogin();
        $this->submitNewJob($this->getClient(), $fieldsJob);
    }

    /**
     * @return array
     */
    public function newActionDataProvider()
    {
        return [
            'Job 1' => [
                'fieldsJob' => ['title' => 'Title Description 1234', 'description' => 'Text Description 1'],
            ],
            'Job 2' => [
                'fieldsJob' => ['title' => 'Title Description 4456', 'description' => 'Text Description 22'],
            ]
        ];
    }

    /**
     * @test
     *
     * @dataProvider updateActionDataProvider
     *
     * @param string   $slug
     * @param array    $fieldsJob
     */
    public function updateAction($slug, $fieldsJob)
    {
        $this->submitLogin();
        $this->submitUpdateJob($this->getClient(), $fieldsJob, $slug);
    }

    /**
     * @return array
     */
    public function updateActionDataProvider()
    {
        return [
            'Job 1' => [
                'slug' => 'test-1',
                'fieldsJob' =>
                    [
                        'title' => 'Title Description From Test',
                        'description' => 'Text Description from From Test'
                    ],
            ]
        ];
    }

    /**
     * @test
     *
     * @dataProvider deleteActionDataProvider
     *
     * @param string   $slug
     */
    public function deleteAction($slug)
    {
        $this->submitLogin();
        $this->submitDeleteJob($this->getClient(), $slug);
    }

    /**
     * @return array
     */
    public function deleteActionDataProvider()
    {
        return [
            'Job 1' => [
                'slug' => 'test-2',
            ]
        ];
    }

    /**
     * @param Client $client
     * @param $fieldsJob
     */
    private function submitNewJob($client, $fieldsJob)
    {
        $crawler = $client->request('GET', '/job/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /job/");
        $crawler = $client->click($crawler->selectLink('Create a new job')->link());

        $form = $crawler->selectButton('Create')->form(array(
            'appbundle_job[title]'  => $fieldsJob['title'],
            'appbundle_job[description]'  => $fieldsJob['description'],
        ));
        $client->submit($form);
    }

    /**
     * @param Client $client
     * @param $fieldsJob
     */
    private function submitUpdateJob($client, $fieldsJob, $slug)
    {
        $editUrl = sprintf('/job/%s/edit', $slug);
        $crawler = $client->request('GET', $editUrl);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode(), $editUrl);
        $form = $crawler->selectButton('Edit')->form(array(
            'appbundle_job[title]'  => $fieldsJob['title'],
            'appbundle_job[description]'  => $fieldsJob['description'],
        ));
        $client->submit($form);
    }

    /**
     * @param Client $client
     * @param $slug
     */
    private function submitDeleteJob($client, $slug)
    {
        $editUrl = sprintf('/job/%s/edit', $slug);
        $crawler = $client->request('GET', $editUrl);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode(), $editUrl);
        $form = $crawler->selectButton('Delete')->form();
        $client->submit($form);
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
