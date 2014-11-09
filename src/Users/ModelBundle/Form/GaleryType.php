<?php

namespace Users\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GaleryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'galeries.name'))

            ->add('save', 'submit',array('attr' => array('class' => 'save'), 'label' => 'galeries.create'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Users\ModelBundle\Entity\Galery',

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'users_modelbundle_galery';
    }
}