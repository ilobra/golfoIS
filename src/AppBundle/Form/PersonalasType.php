<?php

namespace AppBundle\Form;

use AppBundle\Entity\Asmuo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalasType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vardas', TextType::class, [
                'label'=> 'Jūsų vardas ',
                'required' => true,
                'attr' => array('class'=>'form-control', 'style'=>'width:40%', 'maxlength' => '30', 'placeholder'=>'Max 30 simbolių')
            ])
            ->add('pavarde', TextType::class, [
                'label'=> 'Jūsų pavardė ',
                'required' => true,
                'attr' => array('class'=>'form-control', 'style'=>'width:40%', 'maxlength' => '40', 'placeholder'=>'Max 40 simbolių')
            ])
            ->add('asmensKodas', TextType::class, [
                'label'=> 'Asmens kodas ',
                'required' => true,
                'attr' => array('class'=>'form-control', 'style'=>'width:40%', 'maxlength' => '11', 'placeholder'=>'Max 11 simbolių')
            ])
            ->add('elPastas', EmailType::class, [
                'label'=> 'El. paštas ',
                'disabled'=> true,
                'attr' => array('class'=>'form-control', 'style'=>'width:40%', 'maxlength' => '50', 'placeholder'=>'Max 50 simbolių')
            ])
            ->add('plainPassword',PasswordType::class,[
                'label'=> 'Slaptažodis',
                'required'=>false,
                'attr' => array('class'=>'form-control', 'style'=>'width:40%')
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Asmuo::class
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
