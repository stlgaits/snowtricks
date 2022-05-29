<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier, LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->emailVerifier = $emailVerifier;
        $this->logger = $logger;
        $this->mailer = $mailer;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();
                try {
                      // generate a signed url and email it to the user
                        $email = new TemplatedEmail();
                        $email->from('estelle@gaits.com');
                        $email->subject('Confirmation de votre inscription');
                        $email->to($user->getEmail());
                        $email->htmlTemplate('registration/confirmation_email.html.twig');
                        $this->emailVerifier->sendEmailConfirmation(
                            'app_verify_email',
                            $user,
                            $email,
                            [
                            'id' => $user->getId(),
                            'email' => $user->getEmail()
                            ]
                        ); 
                    // do anything else you need here, like send an email
                    $this->addFlash(
                        'success',
                        'An email has been sent to your address! Please validate your account from there.'
                    );
                } catch (TransportExceptionInterface $e) {
                    // some error prevented the email sending; display an
                    // error message or try to resend the message
                    $this->addFlash(
                        'warning',
                        $e->getMessage()
                    );
                    $this->logger->error($e->getMessage().' '.$e->getFile().' '.$e->getLine());
                }
            } catch (Exception $e) {
                $this->logger->error($e->getMessage().' '.$e->getFile().' '.$e->getLine());
                $this->addFlash(
                    'warning',
                    $e->getMessage()
                );
            }
        }

        return $this->renderForm('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        // validate email confirmation link, sets User::isVerified=true and persist
        try {
            $userId = $request->query->get('id');
            $user = $userRepository->find($userId);
            if (!$user) {
                throw $this->createNotFoundException();
            }
            $this->emailVerifier->handleEmailConfirmation($request, $user);
            $this->logger->info('Email verif');
            $this->addFlash('success', 'Your email address has been verified.');
            return $this->redirectToRoute('successful_verification');
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->logger->error('Email verif error : '.$exception->getMessage().' '.$exception->getFile().' '.$exception->getLine());
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
            return $this->redirectToRoute('app_register');
        }

        return $this->redirectToRoute('app_login');
    }

    #[Route('/verify/email/success', name: 'successful_verification')]
    public function succesfulVerification(TranslatorInterface $translator)
    {
        return $this->render('registration/successful_verification.html.twig');
    }
}
