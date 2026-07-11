<?php

namespace App\Controller;

use App\Dto\User\UserCreateDto;
use App\Form\RegisterType;
use App\Service\BrevoService;
use App\Service\UserService;
use App\Security\LoginFormAuthenticator;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function __construct(private readonly BrevoService $brevoService){}

    /**
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserService $userService, UserAuthenticatorInterface $authenticator, LoginFormAuthenticator $loginAuthenticator): Response {

        $dto = new UserCreateDto();
        $form = $this->createForm(RegisterType::class, $dto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dto->roles = ['ROLE_USER'];
            $dto->autoLogin = true;

            $user = $userService->createUser($dto);

            $this->brevoService->sendWelcomeMail(
                $user->getEmail(),
                $user->getProfile()->getFullName(),
            );

            $this->addFlash('success', 'Compte créé !');

            return $authenticator->authenticateUser($user, $loginAuthenticator, $request);
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the firewall logout.');
    }
}
