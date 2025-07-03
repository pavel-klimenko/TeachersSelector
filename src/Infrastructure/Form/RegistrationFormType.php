<?php

namespace App\Infrastructure\Form;

use App\Domain\Entity\City;
use App\Domain\Entity\User;
use App\Domain\Enums\Genders;
use App\Domain\Enums\UserRoles;
use App\Infrastructure\Repository\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function __construct(
        private CityRepository $cityRepository,
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $arRoles = [UserRoles::ROLE_STUDENT, UserRoles::ROLE_TEACHER];

        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('age', NumberType::class)
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($role) => $role->value, $arRoles),
                    array_map(fn($role) => $role->name, $arRoles),
                ),
                'label' => 'User role',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('gender', EnumType::class, [
                'class' => Genders::class,
                'label' => 'Gender',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose the city',
                'required' => true,
            ]);

        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
                fn ($rolesArray) => $rolesArray[0] ?? null,
                fn ($roleString) => [$roleString]
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
