<?php declare(strict_types=1);

namespace App\Application\Expertise\UseCase;
use App\Application\Expertise\DTO\ResponseExpertiseDTO;
use App\Domain\Repository\ExpertiseRepositoryInterface;

class GetAllExpertises
{
    public function __construct(
        private ExpertiseRepositoryInterface $expertiseRepository,
    ){}

    public function execute():array
    {
        $arExpertises = $this->expertiseRepository->getList();

        $arDtoExpertises= [];
        if (!empty($arTeachers)) {
            foreach ($arExpertises as $el) {
                $arDtoExpertises[] = new ResponseExpertiseDTO(
                    $el->getId(),
                    $el->getName(),
                    $el->getCode(),
                );
            }
        }
        return $arDtoExpertises;
    }
}