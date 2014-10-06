<?php

namespace Groups\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'form.name'
            ))
            ->add('description', 'text', array(
                'label' => 'form.description'
            ))
            ->add('groupLogo', 'text', array(
                'required' => false,
                'label' => 'form.logo'
            ))
            ->add('groupCover','text',array(
                'required' => false,
                'label' => 'form.cover'
            ))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Groups\ModelBundle\Entity\Groups'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'groups_modelbundle_groups';
    }
}
