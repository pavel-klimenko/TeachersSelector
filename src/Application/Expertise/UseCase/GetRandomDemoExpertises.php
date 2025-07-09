<?php declare(strict_types=1);

namespace App\Application\Expertise\UseCase;

use App\Domain\Repository\ExpertiseRepositoryInterface;

class GetRandomDemoExpertises
{
    public function __construct(
        private ExpertiseRepositoryInterface $expertiseRepository,
    ){}

    public function execute():array
    {
        $arAllExpertises = $this->expertiseRepository->getList();

        $arRandomExpertises = [];
        if (!empty($arAllExpertises)) {
            $min = 0;
            $max = count($arAllExpertises) - 1;
            for ($i = 0; $i < 3; $i++) {
                $arRandomExpertises[] = $arAllExpertises[rand($min, $max)];
            }
        }

        return $arRandomExpertises;
    }
}