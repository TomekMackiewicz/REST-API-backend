<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('totalAmount', IntegerType::class)
            ->add('unitPrice', IntegerType::class)                
            ->add('quantity', IntegerType::class)                
            ->add('name', TextType::class)                
            ->add('email', TextType::class)                
            ->add('phone', TextType::class)                
            ->add('firstName', TextType::class)                
            ->add('lastName', TextType::class);         
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Payment',
            'allow_extra_fields' => true,
        ]);
    }

    public function getName() {
        return 'payment';
    }

}
