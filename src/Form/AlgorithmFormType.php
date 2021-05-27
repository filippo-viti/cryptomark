<?php

namespace App\Form;

use App\Entity\Algorithm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlgorithmFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('creator', TextType::class)
            ->add('year', IntegerType::class)
            ->add('keyLength', IntegerType::class)
            ->add('digestSize', IntegerType::class)
            ->add('description', TextareaType::class)
            ->add('tags', CollectionType::class, [
                'entry_type' => CategoryTagFormType::class,
                'entry_options' => ['label' => false],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Algorithm::class,
        ]);
    }
}