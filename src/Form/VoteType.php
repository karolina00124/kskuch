<?php
/**
 * VoteType form
 */

namespace App\Form;

use App\Entity\Przepis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VoteType.
 */
class VoteType extends AbstractType
{
    /**
     * Bulids the form.
     *
     * @param FormBuilderInterface $builder form builder
     * @param array                $options the options
     *
     * @see FormTypeExtensionInterface::bulidForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('thumbUp', SubmitType::class, ['label' => '+ '.$options['thumbUpCnt']])
            ->add('thumbDown', SubmitType::class, ['label' => '- '.$options['thumbDownCnt']])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Przepis::class,
            'thumbUpCnt' => 0,
            'thumbDownCnt' => 0,
        ]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'vote';
    }
}
