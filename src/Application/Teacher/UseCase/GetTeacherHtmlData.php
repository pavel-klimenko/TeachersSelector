<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;

use App\Domain\Entity\Teacher;

class GetTeacherHtmlData
{
    public static function execute():array
    {
        return [
            'list_main_title' => [
                'content' => Teacher::LIST_TITLE
            ],
            'select_teachers_page_title' => [
                'content' => Teacher::SELECT_TEACHERS_PAGE_TITLE
            ],
        ];
    }
}