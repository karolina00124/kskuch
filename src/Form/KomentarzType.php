<?php

namespace App\Form;

use App\Entity\Komentarz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KomentarzType extends AbstractType
{

    /**
     * Bulids the form.
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder form builder
     * @param array                                        $options the options
     *
     * @see FormTypeExtensionInterface::bulidForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'tresc',
                TextareaType::class,
                [
                    'label' => 'label_komentarz',
                    'required' => true,
                    'attr' => ['max_length' => 255],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Komentarz::class,
        ]);
    }
    /**
     * Returns the prefix of the template block name for this type.
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'komentarz';
    }
}
