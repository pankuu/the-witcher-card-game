<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

abstract class DataFixtureTestCase extends WebTestCase
{
    /** @var Application $application */
    protected static $application;

    /** @var KernelBrowser $client */
    protected static $client;

    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;

    /** @var bool */
    protected $removeDatabaseAfterTest = true;

    /**
     * {@inheritDoc}
     */
    public static function setUpBeforeClass(): void
    {
        self::runCommand('doctrine:database:drop --force');
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:migration:migrate');
        self::runCommand('doctrine:fixtures:load --append --no-interaction');

        if (null === static::$client) {
            static::$client = static::createClient();
        }

        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass(): void
    {
        if (null === static::$client) {
            static::$client = static::createClient();
        }

        parent::tearDownAfterClass();
    }

    protected function setUp(): void
    {
        if (null === static::$client) {
            static::$client = static::createClient();
        }
        $this->entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        parent::setUp();
    }


    protected static function runCommand($command): int
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication(): Application
    {
        if (null === self::$application
            || null === self::$application->getKernel()->getContainer()) {
            static::$client = static::createClient();

            self::$application = new Application(static::$client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        if (true === $this->removeDatabaseAfterTest) {
            self::runCommand('doctrine:database:drop --force');

            parent::tearDown();

            $this->entityManager->close();
            $this->entityManager = null; // avoid memory leaks
        }

    }

    protected function keepDatabaseAfterTest(): void
    {
        $this->removeDatabaseAfterTest = false;
    }
}