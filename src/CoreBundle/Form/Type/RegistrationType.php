<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月5日
*/
namespace CoreBundle\Form\Type;

use CoreBundle\Form\Type\UserType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends UserType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('user', 'avanzu_profile_user')
            ->add('termsAccepted', null, array('label' => 'form.label.terms_accepted'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('Default', 'Registration'),
            'data_class'         => 'CoreBundle\Form\Model\Registration',
            'cascade_validation' => true,
        ));
    }

    public function getBlockPrefix()
    {
        return 'registration';
    }
}