<?php

namespace App\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FillWalletForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', MoneyType::class, [
                'label' => 'Amount',
                'required' => true,
            ])
            ->add('user_email', HiddenType::class, [
                'label' => 'Email',
                'required' => false,
                'data' => $options['user_email'] ?? '',
            ])
            ->add('user_name', HiddenType::class, [
                'label' => 'Name',
                'required' => false,
                'data' => $options['user_name'] ?? '',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user_email' => null,
            'user_name' => null,
        ]);
    }
}