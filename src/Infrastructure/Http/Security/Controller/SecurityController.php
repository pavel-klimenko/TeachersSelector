<?php

namespace App\Infrastructure\Http\Security\Controller;

use App\Domain\Entity\Student;
use App\Domain\Entity\Teacher;
use App\Domain\Entity\User;
use App\Domain\Enums\UserRoles;
use App\Domain\Factory\CVFactory;
use App\Infrastructure\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Bundle\MakerBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SecurityController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRoles = array_merge($form->get('roles')->getData(), [UserRoles::ROLE_USER->name]);

            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();
            // encode the plain password
            $user
                ->setName($form->get('name')->getData())
                ->setEmail($form->get('email')->getData())
                ->setAge($form->get('age')->getData())
                ->setCity($form->get('city')->getData())
                ->setGender($form->get('gender')->getData())
                ->setRoles($userRoles)
                ->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            if (in_array(UserRoles::ROLE_STUDENT->name, $userRoles)) {
                $student = new Student();
                $student->setRelatedUser($user);
                $entityManager->persist($student);
                $entityManager->flush();
            } elseif (in_array(UserRoles::ROLE_TEACHER->name, $userRoles)) {
                $teacher = new Teacher();
                $teacher->setRelatedUser($user);
                $teacher->setRating(1);
                $entityManager->persist($teacher);
                $entityManager->flush();

                CVFactory::createOne(['teacher' => $teacher]);
            }

            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                    ->from(new Address('teacherSelectorMailer@mail.com', 'TeacherSelector'))
//                    ->to((string) $user->getEmail())
//                    ->subject('Please Confirm your Email')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute('teachers_get_all');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form,
            'title' => 'Registration',
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            /** @var User $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        $currentUser = $this->getUser();

        if (!$currentUser) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/profile.html.twig', [
            'user' => $currentUser,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
            'user' => $this->getUser(),
            'title' => 'Authorization'
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
    }


}
