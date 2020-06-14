<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CallRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => ' ',
                'required' => true,

            ))
            ->add('fname', TextType::class, array(
                'required' => true,
                'label' => ' ',
            ))
            ->add('country', CountryType::class, array(
                'required' => true,
                'label' => ' ',
                'preferred_choices' => array('FR')
            ))
            ->add('phoneNumber', TextType::class, array(
                'label' => ' ',
                'required' => true,

            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Order',
        ));
    }
}