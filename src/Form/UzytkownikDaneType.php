<?php

namespace App\Form;

use App\Entity\UzytkownikDane;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UzytkownikDaneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imie',
                TextType::class,
                [
                    'label' => 'label_imie',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                ]
            )
            ->add('nazwisko',
                TextType::class,
                [
                    'label' => 'label_nazwisko',
                    'required' => true,
                    'attr' => ['max_length' => 280],
                ]
            )
            ->add('email',
                TextType::class,
                [
                    'label' => 'label_email',
                    'required' => true,
                    'attr' => ['max_length' => 120],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UzytkownikDane::class,
        ]);
    }
    /**
     * Returns the prefix of the template block name for this type.
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'UzytkownikDane';
    }
}
