<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class OrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class, array(
            'constraints' => array(
                new Assert\NotBlank()
            )
        ));

        $builder->add('lastname', TextType::class, array(
            'constraints' => array(
                new Assert\NotBlank()
            )
        ));

        $builder->add('address', TextType::class, array(
            'constraints' => array(
                new Assert\NotBlank()
            )
        ));

        $builder->add('address_add', TextType::class, array(
            'required' => false
        ));

        $builder->add('zip', IntegerType::class, array(
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Type("integer")
            )
        ));

        $builder->add('city', TextType::class, array(
            'constraints' => array(
                new Assert\NotBlank()
            )
        ));

        $builder->add('email', TextType::class, array(
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Email()
            )
        ));

        $builder->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'passwords_must_match',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options'  => array('label' => 'password'),
            'second_options' => array('label' => 'password_confirm'),
        ));
    }

    public function getParent()
    {
        return RestoType::class;
    }
}