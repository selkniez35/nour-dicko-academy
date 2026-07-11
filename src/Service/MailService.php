<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final readonly class MailService
{
    public function __construct(
        private MailerInterface $mailer,
        private string $mailSenderEmail,
        private string $mailSenderName,
    ) {
    }

    public function send(
        string $to,
        string $subject,
        string $template,
        array $context = [],
        ?string $recipientName = null,
    ): void {
        $email = (new TemplatedEmail())
            ->from(new Address(
                $this->mailSenderEmail,
                $this->mailSenderName
            ))
            ->to(new Address(
                $to,
                $recipientName ?? ''
            ))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        $this->mailer->send($email);
    }
}
