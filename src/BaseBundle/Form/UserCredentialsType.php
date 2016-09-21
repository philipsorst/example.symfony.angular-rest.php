<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form;

use Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Model\UserCredentials;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCredentialsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'      => UserCredentials::class,
                'csrf_protection' => false
            ]
        );
    }
}
