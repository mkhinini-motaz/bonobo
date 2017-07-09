<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FamilyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('relation', ChoiceType::class, array(
                    'choices'  => array(
                        'Père' => 'Père',
                        'Mère' => 'Mère',
                        'Frère' => 'Frère',
                        'Soeur' => 'Soeur',
                        'Oncle' => 'Oncle',
                        'Tante' => 'Tante',
                        'Cousin' => 'Cousin',
                        'Cousine' => 'Cousine',
                    )
                , 'label' => 'Relation')
        );

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Family'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_family';
    }


}
