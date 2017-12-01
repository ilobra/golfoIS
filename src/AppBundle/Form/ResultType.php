<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Rezultatas;
use AppBundle\Entity\Aikstynas;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ResultType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('raundas', NumberType::class, [
                'label'=> 'Roundų skaičius:*',
                'required' => true,
                'attr' => array('class'=>'form-control', 'style'=>'width:200px', 'maxlength' => '11')
            ])
            ->add('musimuSk', NumberType::class, [
                'label'=> 'Mušimų skaičius:*',
                'required' => true, 
                'attr' => array('class'=>'form-control', 'style'=>'width:200px', 'maxlength' => '11')
            ])
            ->add('fkAikstynasid', EntityType::class, array(
                'label'=> 'Aikštynas:*',
            'class' => 'AppBundle:Aikstynas',
            'choice_label' => 'aikstynoInfo',
            'attr' => array('class'=>'form-control', 'style'=>'width:200px')
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Rezultatas'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_rezultatas';
    }


}
