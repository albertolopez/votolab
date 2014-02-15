<?php
namespace Votolab\VotolabBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CriteriaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'criterion',
                'text',
                array(
                    'required' => true,
                    'label' => 'Criterio',
                    'trim' => true
                )
            )
            ->add(
                'min',
                'text',
                array(
                    'required' => true,
                    'label' => 'Mínimo',
                    'trim' => true
                )
            )
            ->add(
                'max',
                'text',
                array(
                    'required' => true,
                    'label' => 'Máximo',
                    'trim' => true
                )
            );
    }

    public function getName()
    {
        return 'criteria';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Votolab\VotolabBundle\Form\Model\CriteriaFormClass',
            )
        );
    }
}
