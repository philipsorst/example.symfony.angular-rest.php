<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\ReferenceTrait;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\ContainerServicesTrait;
use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class AbstractIntegrationTest extends WebTestCase
{
    use ReferenceTrait;
    use ContainerServicesTrait;

    /**
     * @var ReferenceRepository
     */
    protected $referenceRepository;

    protected function setUp()
    {
        /** @var ORMExecutor $executor */
        $executor = $this->loadFixtures($this->getFixtureClasses());
        $this->referenceRepository = $executor->getReferenceRepository();
        $this->client = static::makeClient();
    }

    /**
     * {@inheritdoc}
     */
    protected function getReference($name)
    {
        return $this->referenceRepository->getReference($name);
    }

    /**
     * @return string[]
     */
    abstract protected function getFixtureClasses();
}
