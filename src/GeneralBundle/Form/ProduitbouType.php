<?php

namespace GeneralBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use GeneralBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        $builder
            ->add('nom',TextType::class,array('label' => 'Nom', 'attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
            ->add('description',TextType::class,array('label' => 'Description', 'attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
            ->add('image',FileType::class,array('label' => 'Image', 'attr' => array('class'=>'btn','style' => 'margin-bottom:15px','value'=>'choisir image'),'data_class' => null))
            ->add('prix',TextType::class,array('label' => 'Prix', 'attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
            ->add('qtetotal',TextType::class,array('label' => 'Quantité', 'attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
            ->add('categorie', ChoiceType::class, [
                'label' => 'Categorie',
                'choices'  => [
                    'Vélo' => 'bike',
                    'Accessoires' => 'accessories',
                    'Autre' => 'other',
                ],
                'attr'=>array('class'=>'form-control form-control-lg','style' => 'margin-bottom:15px'),
                'multiple'=>false
            ])
            ->add('idStore',EntityType::class,array(
                'class'=>'GeneralBundle:Store',
                'label' => 'Nom du store',
                'choices' => $user->getStores(),
                'choice_label'=>'nom',
                'expanded' => false,
                'attr'=>array('class'=>'form-control form-control-lg','style' => 'margin-bottom:15px'),
                'multiple'=>false))
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
