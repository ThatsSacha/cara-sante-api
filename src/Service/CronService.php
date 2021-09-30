<?php

namespace App\Service;

class CronService {
    private $mailerService;
    private $mailTemplateService;

    public function __construct(MailerService $mailerService, MailTemplateService $mailTemplateService) {
        $this->mailerService = $mailerService;
        $this->mailTemplateService = $mailTemplateService;
    }

    public function saveDatabase(string $token) {
        $token = hash('sha512', $token);

        if ($token === '30f89c24cb3823ccd15acada7b97be66de000690309165b7ae615fa03f5fb3bc983a64844bd61596f469200bfe0b87da72ab61ea6b2cae99eac7e55a0a2f8967') {
            shell_exec('/bin/mysqldump --host='. $_ENV['DB_HOST'] .' --user='. $_ENV['DB_USER'] .' --password='. $_ENV['DB_PASSWORD'] .' '. $_ENV['DB_NAME'] .' > ' . $_ENV['DB_FILE_NAME']);

            sleep(5);

            $this->mailerService->sendMail(
                'contact@sacha-cohen.fr',
                'Sauvegarde base de données Cara Santé',
                $this->mailTemplateService->getSaveDatabase(),
                $_ENV['DB_FILE_NAME']
            );

            shell_exec('rm ' . $_ENV['DB_FILE_NAME']);

            return 200;
        } else {
            return 401;
        }
    }
}