<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Dish;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dish', EntityType::class, [
                'class' => Dish::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Блюда',
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',
                'label' => 'Клиенты',
            ])
            ->add('file', FileType::class, [
                'label' => 'Информация о заказе',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',      // JPG
                            'image/png',       // PNG
                            'image/jpg',       // JPG
                            'text/plain',      // TXT
                            'application/pdf', // PDF
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // DOCX
                        ],
                        'mimeTypesMessage' => 'Пожалуйста, загрузите файл в другом формате',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
