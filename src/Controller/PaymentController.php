<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Payment;
use App\Enum\PaymentMethod;
use App\Enum\PaymentStatus;
use App\Repository\PaymentRepository;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use SendinBlue\Client\ApiException;
use Stripe\Exception\ApiErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class PaymentController extends AbstractController
{

    public function __construct(){}
    /**
     * @throws ApiErrorException
     * @throws ApiException
     */
    #[Route('checkout/{id}', name: 'app_pay')]
    public function pay(
        Membership $membership,
        EntityManagerInterface $em,
        StripeService $stripeService
    ): Response {

        $payment = new Payment();

        $payment->setInternalRef(uniqid('pay_', true));
        $payment->setStatus(PaymentStatus::PENDING);
        $payment->setMembership($membership);
        $payment->setAmount((int) ($membership->getPrice() * 100));
        $payment->setMethod(PaymentMethod::CARD);
        $payment->setUser($this->getUser());

        $em->persist($payment);

        $url = $stripeService->createCheckoutSession($payment);

        $em->flush();

        return $this->redirect($url);
    }

    /**
     * @throws ApiException
     */
    #[Route('success', name: 'app_payment_success')]
    public function success(Request $request, PaymentRepository $paymentRepository): Response
    {
        $sessionId = $request->query->get('session_id');

        $payment = $paymentRepository->findOneBy(['stripeSessionId' => $sessionId]);

        if (!$payment) {
            throw $this->createNotFoundException('Payment introuvable');
        }

        $this->brevoService->sendPaymentConfirmation($payment);

        return $this->render('payment/success.html.twig', [
            'session_id' => $sessionId
        ]);
    }

    #[Route('cancel', name: 'app_payment_cancel')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
