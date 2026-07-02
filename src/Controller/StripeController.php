<?php

namespace App\Controller;

use App\Entity\StripeEventLog;
use App\Enum\PaymentStatus;
use App\Repository\PaymentRepository;
use App\Repository\StripeEventLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StripeController extends AbstractController
{
    #[Route('/stripe/webhook', methods: ['POST'])]
    public function webhook(
        Request $request,
        EntityManagerInterface $em,
        PaymentRepository $paymentRepo,
        StripeEventLogRepository $eventRepo
    ): Response {

        $payload = $request->getContent();
        $sig = $request->headers->get('stripe-signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig,
                $_ENV['STRIPE_WEBHOOK_SECRET']
            );
        } catch (\Exception $e) {
            return new Response('invalid', 400);
        }

        // 🧱 1. IDEMPOTENCE STRIPE EVENT
        if ($eventRepo->find($event->id)) {
            return new Response('already processed', 200);
        }

        // log event
        $log = new StripeEventLog();
        $log->setEventId($event->id);
        $log->setType($event->type);
        $log->setPayload($event->data->toArray());

        $em->persist($log);

        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $payment = $paymentRepo->findOneBy([
                'stripeSessionId' => $session->id
            ]);

            if (!$payment) {
                return new Response('payment not found', 404);
            }

            // 🧠 STATE MACHINE
            if ($payment->getStatus() === PaymentStatus::PAID) {
                return new Response('already paid', 200);
            }

            $payment->setStatus(PaymentStatus::PAID);
            $payment->setStripePaymentIntent($session->payment_intent);
            $payment->setPaidAt(new \DateTimeImmutable());
            $payment->setLastStripeEventId($event->id);
        }

        $em->flush();

        return new Response('ok');
    }
}
