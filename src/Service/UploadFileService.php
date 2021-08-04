<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileService {
    /**
     * @param UploadedFile $file
     * @param string $path
     * @param array $authorizedExtensions
     * @param float $maxSizeToMegabytes
     * 
     * @return string
     */
    public function upload(UploadedFile $file, string $path, array $authorizedExtensions, float $maxSizeToMegabytes = 5000): string {
        $format = $this->checkFileExtension($file, $authorizedExtensions);
        $this->checkError($file);
        $this->checkFileSize($file, $maxSizeToMegabytes);
        
        $fileName = uniqid() . '.' . $format;
        $file->move($path, $fileName);

        return $fileName;
    }

    /**
     * @param UploadedFile $file
     * 
     * @throws Exception
     */
    public function checkError(UploadedFile $file) {
        $error = $file->getError();

        if ($error > 0) {
            $error = $file->getErrorMessage();
            throw new Exception($error);
        }
    }

    /**
     * @param UploadedFile $file
     * @param float $maxSizeToMegabytes
     * 
     * @throws Exception
     */
    private function checkFileSize(UploadedFile $file, float $maxSizeToMegabytes) {
        $fileSize = $file->getSize();
        $fileSizeToMegabytes = $fileSize / 1e+6;

        if ($fileSizeToMegabytes > $maxSizeToMegabytes) {
            throw new Exception('File size is too big');
        }
    }

    /**
     * @param UploadedFile $file
     * @param array $authorizedExtensions
     * 
     * @return string
     * 
     * @throws Exception
     */
    public function checkFileExtension(UploadedFile $file, array $authorizedExtensions): string {
        $format = $file->getClientOriginalExtension();

        if (!in_array($format, $authorizedExtensions)) {
            throw new Exception('File extension not allowed');
        }

        return $format;
    }
    
}