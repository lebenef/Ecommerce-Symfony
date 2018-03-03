<?php

namespace FF\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class RegistrationType extends AbstractType
{
  
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('nom', TextType::class )
          ->add('prenom',TextType::class)
          ->add('adresse', TextType::class)
          ->add('codepostal',TextType::class)
          ->add('ville', TextType::class)
          ->add('pays', TextType::class)
          ->add('telephone',  TextType::class);
        
      }
      public function getParent()
      {
        
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';  
      }
  
      public function getName()
    {
    

      return 'ff_user_registration';
    }

}
