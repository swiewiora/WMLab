<?php

namespace AppBundle\Form;

use AppBundle\Entity\Material;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alloyName')
            ->add('chemicalComposition')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Material::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_material';
    }
}
