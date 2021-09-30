<?php

namespace App\Service;

class CronService {
    public function saveDatabase(string $token) {
        shell_exec('/bin/mysqldump --host='. $_ENV['DB_HOST'] .' --user='. $_ENV['DB_USER'] .' --password='. $_ENV['DB_PASSWORD'] .' '. $_ENV['DB_NAME'] .' > savedb.sql');
    }
}