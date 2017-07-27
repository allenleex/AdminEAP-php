<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月5日
*/
namespace CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', 'password')
            ->add('newPassword', 'repeated',
                  array(
                'first_name'  => 'newPassword',
                'second_name' => 'confirm',
                'type'        => 'password',
            ));
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'CoreBundle\Form\Model\ChangePassword',
            'cascade_validation' => true,
        ));
    }
    
    public function getBlockPrefix()
    {
        return 'changepassword';
    }
}