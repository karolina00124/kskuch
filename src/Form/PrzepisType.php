<?php

namespace App\Form;

use App\Entity\Przepis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrzepisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('info')
            ->add('nazwa')
            ->add('skladniki')
            ->add('kroki')
            ->add('dataUtworzenia')
            ->add('kategoria')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Przepis::class,
        ]);
    }
}
