<?php

namespace FF\FastBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProduitsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('name',     TextType::class)
          ->add('description',   TextareaType::class)
          ->add('gammes',     EntityType::class , array(
            'class'        => 'FFFastBundle:Gammes',
            'choice_label' => 'name',
            'multiple'     => false,
          ))
					->add('ingredients',     EntityType::class , array(
            'class'        => 'FFFastBundle:Ingredients',
            'choice_label' => 'name',
            'multiple'     => true,
          ))
		  		->add('images',     ImagesType::class, array('required' => false)) 
          ->add('save',      SubmitType::class);  
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FF\FastBundle\Entity\Produits'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ff_fastbundle_produits';
    }


}
