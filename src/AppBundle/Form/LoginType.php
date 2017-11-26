<?php

namespace AppBundle\Form;

use AppBundle\Entity\Asmuo;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add(
                'elPastas',EmailType::class, [
                    'constraints' => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'slaptazodis',PasswordType::class, [
                    'constraints' => [
                        new NotBlank()
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Asmuo::class,
        ]);
    }
}
