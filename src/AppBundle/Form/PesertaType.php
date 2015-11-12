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
            ->add('name', 'text', array(
				'label' => false,
				'required' => true,
				'attr' => array('class' => 'form-control', 'placeholder' => 'Nama lengkap')
             ))
            ->add('gender', 'choice', array(
				'choices' => array('Wanita' => 'Wanita', 'Pria' => 'Pria'),
				'label' => false,
				'empty_value' => '--Pilih Jenis Kelamin--',
				'required' => true,
				'attr' => array('class' => 'form-control')
            ))
            ->add('origin', 'text', array(
				'label' => false,
				'required' => true,
				'attr' => array('class' => 'form-control', 'placeholder' => 'Asal institusi')
            ))
            ->add('pod', 'text', array(
				'label' => false,
				'required' => true,
				'attr' => array('class' => 'form-control', 'placeholder' => 'Tempat, Tanggal lahir')
            ))
            ->add('address', 'textarea', array(
				'label' => false,
				'required' => true,
				'attr' => array('class' => 'form-control', 'placeholder' => 'Alamat Tinggal')
            ))
            ->add('phone', 'text', array(
				'label' => false,
				'required' => true,
				'attr' => array('class' => 'form-control', 'placeholder' => 'Phone')
			))
			->add('email', 'text', array(
				'label' => false,
				'required' => true,
				'attr' => array('class' => 'form-control', 'placeholder' => 'Email')
			))
			->add('print', 'choice', array(
				'choices' => array('1' => 'Ya _______', '2' => 'Tidak'),
				'expanded' => true,
				'multiple' => false,
				'required' => true,
				'label' => false,
				'data' => 2
			))
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
