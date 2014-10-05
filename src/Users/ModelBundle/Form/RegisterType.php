<?php

namespace Users\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'profile-data.password'),
                'second_options' => array('label' => 'profile-data.rep-password'),
            ))
            ->add('email', 'email', array('label' => 'profile-data.email'))
            ->add('firstName', 'text', array('label' => 'profile-data.first_name'))
            ->add('lastName', 'text', array('label' => 'profile-data.last_name'))
            ->add('country', 'text', array('label' => 'profile-data.country'))
            ->add('state', 'text', array('label' => 'profile-data.state'))
            ->add('city', 'text', array('label' => 'profile-data.city') )
            ->add('address', 'text', array('label' => 'profile-data.address'))
            ->add('phone', 'text', array('label' => 'profile-data.phone'))
            ->add('save', 'submit',array('attr' => array('class' => 'save')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Users\ModelBundle\Entity\User',
            'validation_groups' => array('registration')
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
