<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Register extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('imie', TextType::class)
            ->add('samsCharacterName', TextType::class)
            ->add('isMainCharacter', CheckboxType::class, array(
                'required' => false
            ))
            ->add('rating', IntegerType::class)
            ->add('releasedAt', DateType::class, array(
                'widget' => 'single_text'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'app_bundle_register';
    }
}
