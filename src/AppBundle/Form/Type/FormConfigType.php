<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormConfigType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('allowBack', CheckboxType::class)
            //->add('autoMove', CheckboxType::class)
            //->add('requiredAll', CheckboxType::class)
            ->add('shuffleQuestions', CheckboxType::class)
            ->add('shuffleOptions', CheckboxType::class) 
            ->add('showPager', CheckboxType::class)    
        ;         
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\FormConfig',
            'allow_extra_fields' => true,
        ]);
    }

    public function getName() {
        return 'formConfig';
    }

}
