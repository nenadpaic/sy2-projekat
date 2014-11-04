<?php

namespace Users\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'document.name'))
            ->add('file', 'file', array('label' => 'document.file'))

            ->add('save', 'submit',array('attr' => array('class' => 'save'), 'label' => 'document.button'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Users\ModelBundle\Entity\Documents',

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'users_modelbundle_documents';
    }
}