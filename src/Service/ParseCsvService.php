<?php

namespace App\Service;

use Exception;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ParseCsvService {
    /**
     * @param array $csv
     * 
     * @return void
     */
    public function writeToResult(array $csv): void {
        foreach($csv as $line) {
            if (strtotime($line['date_time']) >= 1625781600) {
                $birth = date_format(date_create($line['patient_birthday']), 'Y-m-d');

                $write = "$line[date_time] $line[patient_first_name] $line[patient_born_name], $line[patient_main_address_address] $line[patient_main_address_zip] $line[patient_main_address_city], $birth, $line[patient_email], $line[patient_phone], n°$line[patient_nir]\n";

                file_put_contents(
                    './uploads/result.txt',
                    $write,
                    FILE_APPEND
                );
            }
        }
    }

    public function parseCsvToArray(string $fileName, string $path): array {
        $path = $path . '/' . $fileName;

        if (file_exists($path)) {
            try {
                $file = file_get_contents($path);

                $serializer = new Serializer(
                                [new ObjectNormalizer()],
                                [new CsvEncoder()]
                            );

                return array(
                    'lines' => $serializer->decode(
                        $file,
                        'csv',
                        [CsvEncoder::DELIMITER_KEY => ';']
                    )
                );
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
        } else {
            throw new Exception('An error occured while opening CSV file');
        }
    }
}