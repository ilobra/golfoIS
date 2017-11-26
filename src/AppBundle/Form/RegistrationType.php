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

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vardas', TextType::class, [
                'label'=> 'Jūsų vardas*',
                'required' => true
            ])
            ->add('pavarde', TextType::class, [
                'label'=> 'Jūsų pavardė*',
                'required' => true
            ])
            ->add('asmensKodas', TextType::class, [
                'label'=> 'Asmens kodas*',
                'required' => true
            ])
            ->add('elPastas', EmailType::class, [
                'label'=> 'El. paštas*'
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => [ 'label' => 'Slaptažodis*' ],
                'second_options' => [ 'label' => 'Pakartoti slaptažodį*' ]
            ))
            ->add('register', SubmitType::class, [
                'attr'=> [
                    'class' => 'btn btn-info btn-lg'
                ]
            ])
        ;
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
