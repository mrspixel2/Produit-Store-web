<?php

namespace GeneralBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
                ->add('description', TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
                ->add("Ajouter",SubmitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'width:100%;margin-bottom:15px')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GeneralBundle\Entity\Store'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'generalbundle_store';
    }


}
