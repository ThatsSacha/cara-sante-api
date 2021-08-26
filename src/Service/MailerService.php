<?php

namespace App\Service;

use Exception;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService {
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendMail(string $sendTo, string $subject, string $htmlTemplate) {
        try {
            $mail = (new Email())
            ->from(new Address('no-reply@carasante.sacha-cohen.fr', 'Cara Santé'))
            ->to($sendTo)
            ->subject($subject)
            ->html($htmlTemplate);

            $this->mailer->send($mail);
        } catch (Exception $e) {
            dd($e);
        }
    }
}