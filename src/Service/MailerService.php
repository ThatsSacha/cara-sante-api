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

    public function sendMail(string $sendTo, string $subject, string $htmlTemplate, ?string $file = null) {
        $mail = (new Email())
        ->from(new Address('no-reply@liora.carasante.io', 'Liora | Cara Santé'))
        ->to($sendTo)
        ->subject($subject)
        ->html($htmlTemplate);

        if ($file !== null) {
            $mail->attachFromPath($file);
        }
        
        try {
            $this->mailer->send($mail);
        } catch (Exception $e) {
            throw new Exception('L\'utilisateur a bien été ajouté mais le mail de confirmation n\'a pas été envoyé car il s\'agit d\'une adresse mail non valide', 200);
        }
    }
}