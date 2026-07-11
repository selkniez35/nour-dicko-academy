<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

readonly class BrevoService
{
    public function __construct(private MailerInterface $mailer, private string $brevoSenderEmail, private string $brevoSenderName){}

    /**
     * @throws TransportExceptionInterface
     */
    public function send(
        string $to,
        string $subject,
        string $template,
        array $context = [],
        ?string $name = null
    ): void {
        $email = new TemplatedEmail()
            ->from(new Address(
                $this->brevoSenderEmail,
                $this->brevoSenderName
            ))
            ->to(new Address($to, $name ?? ''))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        $this->mailer->send($email);
    }
}
