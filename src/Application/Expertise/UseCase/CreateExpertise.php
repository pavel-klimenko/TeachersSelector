<?php declare(strict_types=1);

namespace App\Application\Expertise\UseCase;

use App\Application\Expertise\DTO\CreateExpertiseDTO;
use App\Domain\Repository\ExpertiseRepositoryInterface;
use App\Application\Expertise\Factory\ExpertiseFactory;
use App\Application\Expertise\DTO\ResponseExpertiseDTO;
class CreateExpertise
{
    public function __construct(
        private ExpertiseRepositoryInterface $expertiseRepository,
    ){}

    public function execute(CreateExpertiseDTO $DTO):ResponseExpertiseDTO
    {
        $newExpertise = ExpertiseFactory::makeObject($DTO);
        $this->expertiseRepository->save($newExpertise);

        return new ResponseExpertiseDTO(
            $newExpertise->getId(),
            $newExpertise->getName(),
            $newExpertise->getCode(),
        );
    }
}