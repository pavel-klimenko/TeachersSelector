<?php

namespace App\Domain\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Kernel;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use RuntimeException;


class HelperService
{

    public function getJsonList(string $path)
    {
        $projectDir = '/var/www/app';
        //$filePath = $projectDir . '/public/json/countries_iso_codes.json'; // Путь к файлу

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

//    public function getCountries():array
//    {
//
//
//        $filePath = $projectDir . '/public/json/countries_iso_codes.json'; // Путь к файлу
//
//        if (!file_exists($filePath)) {
//            throw new RuntimeException('File not found');
//        }
//
//        $jsonContent = file_get_contents($filePath);
//        if ($jsonContent === false) {
//            throw new RuntimeException('Error of reading file');
//        }
//
//        $data = json_decode($jsonContent, true);
//        if (json_last_error() !== JSON_ERROR_NONE) {
//            throw new RuntimeException('Error of JSON decoding');
//        }
//
//        return $data;
//    }
//
//    public function getCities():array
//    {
//        $projectDir = '/var/www/app';
//
//        $filePath = $projectDir . '/public/json/cities.json'; // Путь к файлу
//
//        if (!file_exists($filePath)) {
//            throw new RuntimeException('File not found');
//        }
//
//        $jsonContent = file_get_contents($filePath);
//        if ($jsonContent === false) {
//            throw new RuntimeException('Error of reading file');
//        }
//
//        $data = json_decode($jsonContent, true);
//        if (json_last_error() !== JSON_ERROR_NONE) {
//            throw new RuntimeException('Error of JSON decoding');
//        }
//
//        return $data;
//    }
}