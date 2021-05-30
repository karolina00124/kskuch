<?php

namespace App\Form;

use App\Entity\Kategoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('kategoriaNazwa',
                        TextType::class,
                        [
                            'label' => 'label_title',
                            'required' => true,
                            'attr' => ['max_length' => 64],
                        ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Kategoria::class,
        ]);
    }
        /**
         * Returns the prefix of the template block name for this type.
         *
         * @return string The prefix of the template block name
         */
        public function getBlockPrefix(): string
        {
            return 'kategoria';
        }
}

