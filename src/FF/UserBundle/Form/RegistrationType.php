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

class RegistrationType extends BaseType
{
  
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('nom', TextType::class, array('label' => 'Nom'))
          ->add('prenom',TextType::class, array('label' => 'Prenom'))
          ->add('adresse', TextType::class,array('label' => 'Adresse'))
          ->add('codepostal',TextType::class, array('label' => 'Codepost'))
          ->add('ville', TextType::class,array('label' => 'Ville'))
          ->add('telephone',  TextType::class,array('label' => 'Telephone'));
        
      }
      public function getParent()
      {
        
        return 'fos_user_regsitration_register';  
      }
  
      public function getName()
    {
    

      return 'ff_user_registration';
    }

}
