<?php

namespace Groups\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupNewTopicType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'form.topic_name'
            ))
            ->add('message', 'textarea', array(
                'label' => 'form.topic_description'
            ))
            ->add('submit','submit',array(
                'label'=> 'form.create_new_topic'
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Groups\ModelBundle\Entity\GroupTopic'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'groups_modelbundle_grouptopic';
    }
}
