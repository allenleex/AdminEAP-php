<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月4日
*/
namespace ManageBundle\Form;

use ManageBundle\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LoginType extends AbstractType
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, array('label' => 'username','attr'=>array('class'=>'form-control','placeholder'=>'username')))
        ->add('password', PasswordType::class, array('label' => 'password','attr'=>array('class'=>'form-control','placeholder'=>'password')));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'data_class' => Users::class,
            'csrf_field_name' => 'csrf_token',
            'csrf_token_id' => 'newprotoken'
        ));
        
        //$resolver->setRequired('entity_manager');
    }
    
    public function getBlockPrefix()
    {
        return '';
    }
}