<?php declare(strict_types=1);

namespace App\Application\Homepage\UseCase;

class GetHomePageHtmlData
{
    public static function execute():array
    {
        return [
            'main_title' => [
                'content' => 'Teacher selector provides a perfect career opportunity for teachers. You can apply you teaching skills if you exert of:'
            ]
        ];
    }
}