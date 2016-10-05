<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture as BaseFixture;

abstract class AbstractFixture extends BaseFixture
{
    use ReferenceTrait;
}
