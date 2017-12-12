<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class StovejimoAiksteleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vietosNr', NumberType::class, [
                'label'=> 'Aištelės stovėjimo vieta: ',
                'disabled'=> true,
                'attr' => array('class'=>'form-control', 'style'=>'width:200px')
            ])
            ->add('priskyrimoData', DateTimeType::class, [
                'label'=> 'Priskyrimo laikas:',
                'data' => new \DateTime(),
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => array('class'=>'form-control', 'style'=>'width:200px'),

            ])
            ->add('fkAsmuoid', EntityType::class, array(
                'label'=> 'Vartotojas: ',
                'class' => 'AppBundle:Asmuo',
                'choice_label' => function ($asmuo) {
                    return $asmuo->getElPastas() . ' - ' . $asmuo->getTipas();},
                'attr' => array('class'=>'form-control', 'style'=>'width:200px')
            ));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\StovejimoAikstele',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_stovejimoaikstele';
    }


}
