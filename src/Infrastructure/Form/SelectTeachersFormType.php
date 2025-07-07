<?php

namespace App\Infrastructure\Form;

use App\Domain\Entity\City;
use App\Domain\Entity\Expertise;
use App\Domain\Entity\PaymentTypes;
use App\Domain\Entity\StudyingModels;
use App\Infrastructure\Repository\CityRepository;
use App\Infrastructure\Repository\StudyingModelsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SelectTeachersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', IntegerType::class, [
                'data' => 1,
                'label' => 'Teacher`s rating',
                'required' => true,
            ])
            ->add('yearsExperience', IntegerType::class, [
                'data' => 2,
                'label' => 'Minimum years of experience',
                'required' => true,
            ])
            ->add('maxHourRate', IntegerType::class, [
                'label' => 'Max hour rate',
                'required' => true,
            ])
            ->add('studyingModes', EntityType::class, [
                'class' => StudyingModels::class,
                'choice_label' => 'name',
                'placeholder' => 'All',
                'required' => true,
                'multiple' => false,
            ])
            ->add('expertises', EntityType::class, [
                'class' => Expertise::class,
                'choice_label' => 'name',
                'placeholder' => 'All',
                'required' => true,
                'multiple' => true,
            ]);
    }
}