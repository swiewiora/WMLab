<?php

namespace AppBundle\Form;

use AppBundle\Entity\Zwick;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZwickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('material', EntityType::class, array(
                'class' => 'AppBundle:Material',
                'choices' => $options['materials'],
                'choice_label' => 'alloyName', ) )
            ->add('d0', NumberType::class)
            ->add('h0', NumberType::class)
            ->add('t0', NumberType::class)
            ->add('v0', NumberType::class)
            ->add('ag', NumberType::class)
            ->add('agt', NumberType::class)
            ->add('at', NumberType::class)
            ->add('e', NumberType::class)
            ->add('r', NumberType::class)
            ->add('fm', NumberType::class)
            ->add('rm', NumberType::class)
            ->add('rb', NumberType::class)
            ->add('fileTra', FileType::class, array('label' => "Input Data (TRA file)"))
            ->add('filePdf', FileType::class, array('label' => "Report (PDF file)"))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Zwick::class,
            'materials' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_zwick';
    }
}
