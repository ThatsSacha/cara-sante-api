<?php

namespace App\Service;

use App\Entity\Users;

class ContactService {
    private $usersService;
    private $mailerService;
    private $mailTemplateService;

    public function __construct(MailerService $mailerService, MailTemplateService $mailTemplateService, UsersService $usersService) {
        $this->mailerService = $mailerService;
        $this->usersService = $usersService;
        $this->mailTemplateService = $mailTemplateService;
    }

    public function contact(array $data, Users $user) {
        $this->usersService->verifyMandatoryFields(['subject', 'message'], $data);
        $data['message'] = nl2br($data['message']);

        $this->mailerService->sendMail(
            'tech@liora.sacha-cohen.fr',
            $data['subject'],
            $this->mailTemplateService->getContactTemplate($data, $user),
            null,
            $user->getEmail()
        );

        return array(
            'status' => 200
        );
    }
}