<?php

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;


/**
 * Class AbstractTestCase
 */
abstract class AbstractFunctionalTest extends WebTestCase
{
    /**
     * @var bool
     */
    protected static $dataChanged = true;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Setup
     */
    protected function setUp()
    {
        $this->client = static::createClient();
        if (static::isDataChanged()) {
            $this->flushDatabase();
            static::setDataChanged(false);
        }
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return boolean
     */
    public static function isDataChanged()
    {
        return self::$dataChanged;
    }

    /**
     * @param boolean $dataChanged
     */
    public static function setDataChanged($dataChanged)
    {
        self::$dataChanged = $dataChanged;
    }

    private function flushDatabase() {

        shell_exec('php bin/console doctrine:database:drop --force --env=test;');
        shell_exec('php bin/console doctrine:database:create --env=test;');
        shell_exec('php bin/console doctrine:schema:update --force --env=test;');
        shell_exec('php bin/console doctrine:fixtures:load --env=test --append;');
    }
}
