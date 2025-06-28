<?php

namespace App\Infrastructure\Http;

use App\Domain\Entity\Country;
use App\Domain\Entity\Student;
use App\Domain\Entity\User;
use App\Domain\Enums\Genders;
use App\Domain\Repository\CityRepository;
use App\Domain\Services\HelperService;
use App\Infrastructure\Repository\CountryRepository;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class TestController extends AbstractController
{

    public function __construct(
        private UserRepository $userRepository,
        private StudentRepository $studentRepository,
        private CountryRepository $countryRepository,
        private CityRepository $cityRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager
    )
    {}

    #[Route('/test', name: 'test')]
    public function index(): Response
    {
        $arUsers = $this->userRepository->findAll();

        $minskCity = $this->cityRepository->findOneBy(['code' => 'minsk']);

        foreach ($arUsers as $user) {
            dump($user);
            //dd($user->getRoles());

            if (in_array('ROLE_STUDENT', $user->getRoles())) {
                $student = new Student();

                $student->setCity($minskCity)
                    ->setName('asdasd')
                    ->setAge(30)
                    ->setGender(Genders::MALE)
                    ->setMaxRatePerHour(20)
                    ->setRelatedUser($user);

                $this->entityManager->persist($student);
                $this->entityManager->flush();
            }
        }

//            $student = new Student();
//
//            $student->setCity()


//            $this->entityManager->persist($user);
//            $this->entityManager->flush();

//            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                    ->from(new Address('teacherSelectorMailer@mail.com', 'TeacherSelector'))
//                    ->to((string) $user->getEmail())
//                    ->subject('Please Confirm your Email')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
//
//            // do anything else you need here, like send an email
//
//            return $this->redirectToRoute('teachers_get_all');

            exit();
    }


    function getCountries()
    {

    }

}
