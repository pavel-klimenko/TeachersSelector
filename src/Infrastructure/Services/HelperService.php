<?php

namespace App\Infrastructure\Services;

use App\Domain\Services\HelperServiceInterface;
use RuntimeException;

class HelperService implements HelperServiceInterface
{
    public function getJsonList(string $path)
    {
        $projectDir = '/var/www/app';
        $filePath = $projectDir . $path;

        if (!file_exists($filePath)) {
            throw new RuntimeException('File not found');
        }

        $jsonContent = file_get_contents($filePath);
        if ($jsonContent === false) {
            throw new RuntimeException('Error of reading file');
        }

        $data = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Error of JSON decoding');
        }

        return $data;
    }
}