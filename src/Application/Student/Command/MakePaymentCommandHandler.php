<?php
declare(strict_types=1);

namespace App\Application\Student\Command;

use App\Domain\Bus\Command\CommandHandler;

class MakePaymentCommandHandler implements CommandHandler
{
//    public function __construct(private EmailRepository $repository)
//    {
//    }
//
//    public function __invoke(CreateEmailCommand $command) : EmailId {
//        $email = Email::createNewEmail(
//            sender: new EmailAddress($command->sender()),
//            addressee: new EmailAddress($command->addressee()),
//            message: new Message($command->message()),
//        );
//
//        $this->repository->save($email);
//
//        return $email->id();
//    }
}