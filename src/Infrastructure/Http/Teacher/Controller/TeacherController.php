<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Teacher\Controller;

//use App\Application\Teacher\CreateTeacherUseCase;

use App\Domain\Entity\Teacher;
use App\Domain\Enums\Genders;
use App\Infrastructure\Form\SelectTeachersFormType;
use App\Infrastructure\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    public function getById(TeacherRepository $teacherRepository, int $id)
    {
        $teacher = $teacherRepository->findOneBy(['id' => $id]);


        $arExpertises = [];
        foreach ($teacher->getTeacherHasTeacherExpertises() as $expertise) {
            $arExpertises[$expertise->getExpertise()->getName()] = $expertise->getRating();
        }

        $arStudyingModes = [];
        foreach ($teacher->getStudyingModes() as $mode) {
            $arStudyingModes[] = $mode->getName();
        }

        $arPaymentTypes = [];
        foreach ($teacher->getPaymentTypes() as $type) {
            $arPaymentTypes[] = $type->getName();
        }

        return $this->render('teachers/detail.html.twig', [
            'title' => 'CV - '.$teacher->getRelatedUser()->getName(),
            'teacher' => $teacher,
            'expertises' => $arExpertises,
            'studying_modes' => $arStudyingModes,
            'payment_types' => $arPaymentTypes,
            'max_teacher_expertise_rating' => 5, //TODO CONST
        ]);
    }

    #[Route('/teachers', name: 'teachers_get_all')]
    public function getAll(TeacherRepository $teacherRepository)
    {
        $teachers = $teacherRepository->findAll();
        return $this->render('teachers/list.html.twig', [
            'title' => 'Our teachers',
            'teachers' => $teachers,
            'max_teacher_common_rating' => 10 //TODO const
        ]);
    }

    public function selectTeachers(TeacherRepository $teacherRepository, Request $request): Response
    {
        $form = $this->createForm(SelectTeachersFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Обработка данных формы
            $data = $form->getData();

            $arFilter = [];
            $arFilter['rating'] = $data['rating'];
            $arFilter['maxRate'] = $data['maxHourRate'];
            $arFilter['yearsOfExperience'] = $data['yearsExperience'];
            $arFilter['studyingModeId'] = $data['studyingModes'];

            $arFilter['expertises_ids'] = [];
            if (!$data['expertises']->isEmpty()) {
                foreach ($data['expertises'] as $expertise) {
                    $arFilter['expertises_ids'][] = $expertise->getId();
                }
            }

            $arTeaches = $teacherRepository->findTeachersByFilter($arFilter);
            return $this->render('teachers/list.html.twig', [
                'title' => 'Our teachers',
                'teachers' => $arTeaches,
                'max_teacher_common_rating' => 10 //TODO const
            ]);
        }

        return $this->render('student/select_teachers.html.twig', [
            'selectTeachersForm' => $form->createView(),
        ]);
    }
}
