<?php

namespace Users\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileInfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array(
                'label' => 'profile-data.first_name'
            ))
            ->add('lastName', 'text', array(
                'label' => 'profile-data.last_name'
            ))
            ->add('country', 'text', array('required' => false, 'label' => 'profile-data.country'))
            ->add('state', 'text', array('required' => false, 'label' => 'profile-data.state'))
            ->add('city', 'text', array('required' => false, 'label' => 'profile-data.city'))
            ->add('address', 'text', array('required' => false, 'label' => 'profile-data.address'))
            ->add('phone', 'text', array(
                'label' => 'profile-data.phone'
            ))

            ->add('save', 'submit',array('attr' => array('class' => 'save')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Users\ModelBundle\Entity\User',
            'validation_groups' => array('profile')
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
