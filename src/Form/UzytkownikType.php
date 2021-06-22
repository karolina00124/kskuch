<?php

namespace App\Form;

use App\Entity\Uzytkownik;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UzytkownikType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nazwa_uzytkownik',
                TextType::class,
                [
                    'label' => 'label_nazwa_uzytkownik',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                ]
            )
        ;
        $builder->add('uzytkownikDane', UzytkownikDaneType::class);
        $builder->add('newPassword', RepeatedType::class, [
            'mapped' => false,
            'type' => PasswordType::class,
            'invalid_message' => 'Hasła muszą się zgadzać',
            'options' => ['attr' => ['class' => 'password-field']],
            'first_options'  => ['label' => 'label_password'],
            'second_options' => ['label' => 'label_password_repeat'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Uzytkownik::class,
        ]);
    }
    /**
     * Returns the prefix of the template block name for this type.
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'Uzytkownik';
    }
}