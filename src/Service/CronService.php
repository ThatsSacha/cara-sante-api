<?php

namespace App\Service;

class CronService {
    private $mailerService;
    private $mailTemplateService;
    private $detectionTestService;

    public function __construct(MailerService $mailerService, MailTemplateService $mailTemplateService, DetectionTestService $detectionTestService) {
        $this->mailerService = $mailerService;
        $this->mailTemplateService = $mailTemplateService;
        $this->detectionTestService = $detectionTestService;
    }

    public function saveDatabase(string $token) {
        $token = hash('sha512', $token);

        if ($token === $_ENV['HASHED_CRON_SAVE_DB']) {
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

    public function setUpdating(string $token) {
        $token = hash('sha512', $token);

        if ($token === $_ENV['HASHED_CRON_SET_UPDATING']) {
            $this->detectionTestService->cronSetUpdating();

            return 200;
        } else {
            return 401;
        }
    }
}