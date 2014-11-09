<?php

namespace Users\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array('required' => false))
            ->add('lastName', 'text', array('required' => false))
            ->add('country', 'text', array('required' => false))
            ->add('state', 'text', array('required' => false))
            ->add('city', 'text', array('required' => false))
            ->add('address', 'text', array('required' => false))
            ->add('phone', 'text', array('required' => false))
            ->add('active', 'choice', array('choices' => array('0' => 'Not activated', '1' => 'Active')))
            ->add('save', 'submit',array('attr' => array('class' => 'save')));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Users\ModelBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'users_modelbundle_user';
    }
}
