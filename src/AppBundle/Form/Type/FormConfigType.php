<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormConfigType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('allowBack', IntegerType::class)
            ->add('allowReview', IntegerType::class)
            ->add('autoMove', IntegerType::class)
            ->add('duration', IntegerType::class)
            ->add('pageSize', IntegerType::class)
            ->add('requiredAll', IntegerType::class)
            ->add('richText', IntegerType::class)
            ->add('shuffleQuestions', IntegerType::class)
            ->add('shuffleOptions', IntegerType::class)
            ->add('showClock', IntegerType::class) 
            ->add('showPager', IntegerType::class)    
            ->add('theme', TextType::class)
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
