<?php

namespace App\Controller;

use App\Dto\User\UserCreateDto;
use App\Form\RegisterType;
use App\Service\MailService;
use App\Service\UserService;
use App\Security\LoginFormAuthenticator;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function __construct(private readonly MailService $brevoService){}

    /**
     * @throws TransportExceptionInterface
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

            $this->brevoService->sendWelcome(
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

        if ($error) {
            $this->addFlash('login_error', 'Email ou mot de passe incorrect.');
        }

        return new RedirectResponse($this->generateUrl('app_membership-plan_index') . '#modal-connexion');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the firewall logout.');
    }
}
