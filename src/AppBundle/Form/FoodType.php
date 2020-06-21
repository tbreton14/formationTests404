<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entitled', TextType::class, ['label' => 'Ingrédient'])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Légume' => 'Légume',
                    'Fruit' => 'Fruit',
                    'Viande' => 'Viande',
                    'Poisson' => 'Poisson',
                    'Produit laitier' => 'Produit laitier',
                    'Céréale et féculent' => 'Céréale et féculent',
                    'Boisson' => 'Boisson',
                    'œufs' => 'œufs',
                    'Corp gras' => 'Corp gras',
                    'Sucre' => 'Sucre',
                ],
                'label' => 'Type'

            ])
            ->add('calories', IntegerType::class, ['label' => 'Calories'])
            ->add('teneurProteine', IntegerType::class, ['label' => 'Teneur en protéines (g)'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FoodRecord'
        ));
    }
}