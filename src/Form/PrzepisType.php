<?php
/**
 * PrzepisType form
 */

namespace App\Form;

use App\Entity\Kategoria;
use App\Entity\Przepis;
use App\Form\DataTransformer\TagiDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 */
class PrzepisType extends AbstractType
{
    /**
     * Tagi data transformer.
     */
    private TagiDataTransformer $tagiDataTransformer;

    /**
     * TagType constructor.
     *
     * @param TagiDataTransformer $tagiDataTransformer
     */
    public function __construct(TagiDataTransformer $tagiDataTransformer)
    {
        $this->tagiDataTransformer = $tagiDataTransformer;
    }

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
                'nazwa',
                TextType::class,
                [
                    'label' => 'label_title',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                ]
            )
            ->add(
                'info',
                TextType::class,
                [
                    'label' => 'label_info',
                    'required' => true,
                    'attr' => ['min_length' => 3, 'max_length' => 150],
                ]
            )
            ->add(
                'skladniki',
                TextareaType::class,
                [
                    'label' => 'label_skladniki',
                    'required' => true,
                    'attr' => ['min_length' => 3],
                ]
            )
            ->add(
                'kroki',
                TextareaType::class,
                [
                    'label' => 'label_kroki',
                    'required' => true,
                    'attr' => ['min_length' => 8],
                ]
            );
        $builder->add(
            'kategoria',
            EntityType::class,
            [
                      'class' => Kategoria::class,
                      'choice_label' => function ($kategoria) {
                          return $kategoria->getKategoriaNazwa();
                      },
                      'label' => 'label_kategoria',
                      'placeholder' => 'choose_category',
                      'required' => true,
                   ]
        );
        $builder->add(
            'tagi',
            TextType::class,
            [
            'label' => 'label_tags',
            'attr' => ['max_length' => 128],
            'required' => false,
            ]
        );
        $builder
            ->get('tagi')->addModelTransformer(
                $this->tagiDataTransformer
            );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Przepis::class,
        ]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'przepis';
    }
}
