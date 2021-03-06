<?php

namespace App\Form;

use App\Entity\Algorithm;
use App\Entity\CategoryTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('creator', TextType::class, [
                'required' => false
            ])
            ->add('year', IntegerType::class, [
                'required' => false
            ])
            ->add('keyLength', IntegerType::class, [
                'required' => false
            ])
            ->add('digestSize', IntegerType::class, [
                'required' => false
            ])
            ->add('shortDescription', TextType::class)
            ->add('description', TextareaType::class, [
                'row_attr' => ['id' => 'descriptionEditor'],
            ])
            ->add('tags', EntityType::class, [
                'class' => CategoryTag::class,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Algorithm::class,
            'csrf_protection' => false,
        ]);
    }
}