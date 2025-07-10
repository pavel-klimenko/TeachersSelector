<?php

namespace App\Infrastructure\Form;

use App\Domain\Entity\CV;
use App\Domain\Entity\Expertise;
use App\Domain\Entity\StudyingMode;
use App\Domain\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
class SelectTeachersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', IntegerType::class, [
                'data' => Teacher::MIN_RATING,
                'label' => 'Teacher`s rating',
                'required' => true,
            ])
            ->add('yearsExperience', IntegerType::class, [
                'data' => CV::MIN_YEARS_EXPERIENCE,
                'label' => 'Minimum years of experience',
                'required' => true,
            ])
            ->add('maxHourRate', IntegerType::class, [
                'label' => 'Max hour rate',
                'required' => true,
            ])
            ->add('studyingModes', EntityType::class, [
                'class' => StudyingMode::class,
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