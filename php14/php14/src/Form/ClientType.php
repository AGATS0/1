<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Введите ваше имя'
                ],
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\NotBlank([
                        'message' => 'Имя обязательно для заполнения'
                    ])
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Номер телефона',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Введите номер телефона'
                ]
            ]);

        if ($options['with_password']) {
            $builder->add('plainPassword', PasswordType::class, [
                'label' => 'Пароль',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Введите пароль'
                ],
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\NotBlank([
                        'message' => 'Пароль обязателен'
                    ]),
                    new \Symfony\Component\Validator\Constraints\Length([
                        'min' => 6,
                        'minMessage' => 'Пароль должен содержать минимум {{ limit }} символов'
                    ])
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'with_password' => true,
        ]);

        $resolver->setAllowedTypes('with_password', 'bool');
    }
}