<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PresentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('name','text', array(
					'attr' => array('class' => 'form-control'),
					'required' => true,
					'label' => false
				))
            ->add('print', 'choice', array(
					'choices' => array('1' => 'Ya ____', '2' => 'Tidak'),
					'expanded' => true,
					'multiple' => false,
					'required' => true,
					'label' => false,
					'data' => 1
				));
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
        return 'appbundle_present';
    }
}
