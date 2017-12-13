<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AikstynoTvarkymasType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('komentaras', TextareaType::class, [
            'label'=> 'Komentaras: ',
            'required' => false,
            'attr' => array('class'=>'form-control', 'style'=>'width:90%')
        ])
        ->add('data', DateTimeType::class, [
            'label'=> 'Pasirinkta data: ',
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'disabled' => true,
            'attr' => array('class'=>'form-control', 'style'=>'width:90%')
        ])
        ->add('pradziosLaikas', TimeType::class, [
            'label'=> 'Pradžios laikas: ',
            'disabled' => true,
            'widget' => 'single_text',
            'attr' => array('class'=>'form-control', 'style'=>'width:90%')
        ])
        ->add('pabaigosLaikas', TimeType::class, [
            'label'=> 'Pabaigos laikas: ',
            'disabled' => true,
            'widget' => 'single_text',
            'model_timezone' => 'UTC',
            // 'view_timezone' => $timeZoneName,
            'attr' => array('class'=>'form-control', 'style'=>'width:90%')
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AikstynoTvarkymas'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_aikstynotvarkymas';
    }


}
