<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PesertaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('timestamp')
            ->add('name')
            ->add('gender')
            ->add('origin')
            ->add('pod')
            ->add('bod')
            ->add('address')
            ->add('phone')
            ->add('email')
            ->add('present')
            ->add('print')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Peserta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_peserta';
    }
}
