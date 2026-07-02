<?php

namespace App\Controller;

use App\Entity\MembershipPlan;
use App\Entity\Payment;
use App\Enum\PaymentMethod;
use App\Enum\PaymentStatus;
use App\Repository\PaymentRepository;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Exception\ApiErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
class PaymentController extends AbstractController
{
    public function __construct(private readonly StripeService $stripeService){}
    /**
     * @throws ApiErrorException
     */
    #[Route('/checkout/{id}', name: 'app_pay')]
    public function pay(EntityManagerInterface $em, MembershipPlan $membershipPlan): Response {

        $payment = new Payment();

        $payment->setInternalRef(uniqid('pay_', true));
        $payment->setStatus(PaymentStatus::PENDING);
        $payment->setMethod(PaymentMethod::CARD);
        $payment->setAmount($membershipPlan->getPrice() * 100);

        $em->persist($payment);

        $url = $this->stripeService->createCheckoutSession($payment);

        $em->flush();

        return $this->redirect($url);
    }

    #[Route('/payment/success', name: 'app_payment_success')]
    public function success(Request $request, PaymentRepository $paymentRepository): Response
    {
        $sessionId = $request->query->get('session_id');

        $payment = $paymentRepository->findOneBy(['stripeSessionId' => $sessionId]);

        if (!$payment) {
            throw $this->createNotFoundException('Payment introuvable');
        }

        return $this->render('payment/success.html.twig', [
            'session_id' => $sessionId
        ]);
    }


    #[Route('/payment/cancel', name: 'app_payment_cancel')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
