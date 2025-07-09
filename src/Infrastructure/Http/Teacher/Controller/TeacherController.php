<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Teacher\Controller;

use App\Application\Teacher\UseCase\GetAll;
use App\Application\Teacher\UseCase\GetOne;
use App\Application\Teacher\UseCase\Select;
use App\Infrastructure\Form\SelectTeachersFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TeacherController extends AbstractController
{
    public function __construct(
        private GetAll $getAllTeachersCase,
        private GetOne $getOneCase,
        private Select $selectCase,
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
        $teachers = $this->getAllTeachersCase->execute();
        return $this->render('teachers/list.html.twig', [
            'title' => 'Our teachers',
            'teachers' => $teachers,
            'max_teacher_common_rating' => 10 //TODO const
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
                'max_teacher_common_rating' => 10 //TODO const
            ]);
        }

        return $this->render('student/select_teachers.html.twig', [
            'selectTeachersForm' => $form->createView(),
        ]);
    }
}
