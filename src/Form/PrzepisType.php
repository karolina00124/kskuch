<?php

namespace App\Form;

use App\Entity\Kategoria;
use App\Entity\Przepis;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrzepisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('info', TextType::class,
                [
                    'label' => 'label_info',
                    'required' => true,
                    'attr' => ['min_length' => 3, 'max_length' => 150],
                ]
            )
            ->add('nazwa', TextType::class,
                [
                    'label' => 'label_title',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                ]
            )
            ->add('skladniki', TextType::class,
                [
                    'label' => 'label_ingredients',
                    'required' => true,
                    'attr' => ['min_length' => 3],
                ])
            ->add('kroki', TextType::class,
                [
                    'label' => 'label_steps',
                    'required' => true,
                    'attr' => ['min_length' => 8],
                ])
            ->add('kategoria', EntityType::class,
                  [
                      'class' => Kategoria::class,
                      'choice_label' =>function($kategoria){
                            return $kategoria->getKategoriaNazwa();
                      },
                      'label'=>'label_category',
                      'placeholder'=>'label_none',
                      'required'=>true,

                   ]
            )
        ;
    }

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
