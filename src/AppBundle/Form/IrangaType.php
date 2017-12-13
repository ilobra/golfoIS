<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IrangaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('kokybe', ChoiceType::class, [
            'label'=> 'Kokybės nurodymas: ',
            'choices' => [
                'l. gera' => 'l. gera',
                'puiki' => 'puiki',
                'ideali' => 'ideali',
                'gera' => 'gera',
                'normali' =>'normali',
                'nebloga' =>'nebloga' ,
                'su pabraižymais' => 'su pabraižymais',
            ],
            'attr' => array('class'=>'form-control', 'style'=>'width:200px')
        ])
        ->add('isigijimoData', DateType::class, [
        'label'=> 'Įsigyjimo data:',
        'widget' => 'single_text',
        'format' => 'yyyy-MM-dd',
        'attr' => array('class'=>'form-control', 'style'=>'width:200px')
    ])
        ->add('tipas', EntityType::class, array(
        'label'=> 'Įrangos tipas: ',
        'class' => 'AppBundle:IrangosTipas',
        'choice_label' => 'name',
        'attr' => array('class'=>'form-control', 'style'=>'width:200px')
    ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Iranga'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_iranga';
    }


}
