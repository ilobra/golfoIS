<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AsmuoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('vardas', TextType::class,[
            'label'=> 'Vardas',

            'attr' => array('class'=>'form-control', 'style'=>'width:40%')
        ])
            ->add('pavarde',TextType::class,[
                'label'=> 'Pavardė',

                'attr' => array('class'=>'form-control', 'style'=>'width:40%')
            ])

            ->add('asmensKodas',TextType::class,[
                'label'=> 'Asmens kodas',
                'attr' => array('class'=>'form-control', 'style'=>'width:40%')
            ])
            ->add('elPastas',EmailType::class,[
                'label'=> 'El. paštas',
                'attr' => array('class'=>'form-control', 'style'=>'width:40%')
            ])
            ->add('plainPassword',PasswordType::class,[
                'label'=> 'Slaptažodis',
                'required'=>false,
                'attr' => array('class'=>'form-control', 'style'=>'width:40%')
            ])
            ->add('tipas');
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Asmuo',
            'data_class2'=>'AppBundle\Entity\AsmensTipas'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_asmuo';
    }


}
