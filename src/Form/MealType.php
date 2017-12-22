<?php


namespace App\Form;

use App\Model\Meal;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var $meal Meal */
        $meal = $options['meal'];

        $builder->add('quantity', IntegerType::class, array(
            'data' => 1,
            'label' => "Quantité",
            'attr' => array("min" => 1, "max" => $meal->getQuantityInStock()),
            'constraints' => array(new Assert\GreaterThan(0), new Assert\NotBlank())
        ))
            ->add('meal_id', HiddenType::class, array(
                'data' => $meal->getId()
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('meal')
            ->setAllowedTypes('meal', Meal::class);
    }

    public function getParent()
    {
        return RestoType::class;
    }

}