<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\Validator;

use Symfony\Component\Validator\Constraint;

class FixedId extends Constraint
{
    public $message = "The id must not change";
}
