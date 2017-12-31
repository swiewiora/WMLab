<?php

namespace AppBundle\Form;

use AppBundle\Entity\Zwick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZwickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('d0', NumberType::class)
            ->add('h0', NumberType::class)
            ->add('t0', NumberType::class)
            ->add('t1', NumberType::class)
            ->add('korr', NumberType::class)
            ->add('file', FileType::class, array('label' => "Input Data (CSV file)"))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Zwick::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_zwick';
    }
}
