<?php
/**
 * TagType form
 */

namespace App\Form;

use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 */
class TagType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param FormBuilderInterface $builder form builder
     * @param array                $options the options
     *
     * @see FormTypeExtensionInterface::bulidForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'tagNazwa',
                TextType::class,
                [
                    'label' => 'label_title',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'tag';
    }
}
