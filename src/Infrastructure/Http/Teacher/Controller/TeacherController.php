<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Teacher\Controller;

use App\Application\Teacher\UseCase\GetAllTeachers;
use App\Application\Teacher\UseCase\GetTeacher;
use App\Application\Teacher\UseCase\GetTeacherHtmlData;
use App\Application\Teacher\UseCase\SelectTeachers;
use App\Domain\Entity\Teacher;
use App\Infrastructure\Form\SelectTeachersFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TeacherController extends AbstractController
{
    public function __construct(
        private GetAllTeachers $getAllTeachersCase,
        private GetTeacher         $getOneCase,
        private SelectTeachers         $selectCase,
        private GetTeacherHtmlData         $GetTeacherHtmlDataCase,
    ){}

    public function getById(int $id)
    {
        $teacher = $this->getOneCase->execute($id);

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
        $teachers = $this->getAllTeachersCase->executeDTOs();
        $teacherHtmlData = $this->GetTeacherHtmlDataCase->execute();
        return $this->render('teachers/list.html.twig', [
            'title' => $teacherHtmlData['list_main_title']['content'],
            'teachers' => $teachers,
            'max_teacher_common_rating' => Teacher::MAX_RATING,
        ]);
    }

    public function selectTeachers(Request $request): Response
    {
        $form = $this->createForm(SelectTeachersFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teachers = $this->selectCase->execute($form->getData());

            return $this->render('teachers/list.html.twig', [
                'title' => 'Our teachers',
                'teachers' => $teachers,
                'max_teacher_common_rating' => Teacher::MAX_RATING
            ]);
        }

        return $this->render('student/select_teachers.html.twig', [
            'selectTeachersForm' => $form->createView(),
        ]);
    }
}
