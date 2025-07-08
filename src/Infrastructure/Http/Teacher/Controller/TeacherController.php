<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Teacher\Controller;

use App\Application\Teacher\UseCase\GetAll;
use App\Application\Teacher\UseCase\GetOne;
use App\Infrastructure\Form\SelectTeachersFormType;
use App\Infrastructure\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class TeacherController extends AbstractController
{
    public function __construct(
        private GetAll $getAllTeachersCase,
        private GetOne $getOne,
    ){}

    public function getById(int $id)
    {
        $teacher = $this->getOne->execute($id);



        $arExpertises = [];
        foreach ($teacher->hasTeacherExpertises as $expertise) {
            $arExpertises[$expertise->getExpertise()->getName()] = $expertise->getRating();
        }

        $arStudyingModes = [];
        foreach ($teacher->studying_modes as $mode) {
            $arStudyingModes[] = $mode->getName();
        }

        $arPaymentTypes = [];
        foreach ($teacher->payment_types as $type) {
            $arPaymentTypes[] = $type->getName();
        }


        dd([
            'title' => 'CV - '.$teacher->related_user->getName(),
            'teacher' => $teacher,
            'expertises' => $arExpertises,
            'studying_modes' => $arStudyingModes,
            'payment_types' => $arPaymentTypes,
            'max_teacher_expertise_rating' => 5, //TODO CONST
        ]);

        return $this->render('teachers/detail.html.twig', [
            'title' => 'CV - '.$teacher->related_user->getName(),
            'teacher' => $teacher,
            'expertises' => $arExpertises,
            'studying_modes' => $arStudyingModes,
            'payment_types' => $arPaymentTypes,
            'max_teacher_expertise_rating' => 5, //TODO CONST
        ]);
    }

    #[Route('/teachers', name: 'teachers_get_all')]
    public function getAll()
    {
        $teachers = $this->getAllTeachersCase->execute();
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
