<?php

namespace GeneralBundle\Form;

use GeneralBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitbouType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder->add('prix',TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
            ->add('nom',TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
            ->add('description',TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
            ->add('image',FileType::class,array('attr' => array('class'=>'btn','style' => 'margin-bottom:15px','value'=>'choisir image'),'data_class' => null))
            ->add('qtetotal',TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
            ->add('idStore',EntityType::class,array(
                'class'=>'GeneralBundle:Store',
                'choices' => $user->getStores(),
                'choice_label'=>'nom',
                'attr'=>array('class'=>'form-control form-control-lg','style' => 'margin-bottom:15px'),
                'multiple'=>true))
            ->add("Ajouter",SubmitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'width:100%;margin-bottom:15px')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GeneralBundle\Entity\Produitbou'
        ));
        $resolver->setRequired('user');
        // type validation - User instance or int, you can also pick just one.
        $resolver->setAllowedTypes('user', array(User::class));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'generalbundle_produitbou';
    }


}
