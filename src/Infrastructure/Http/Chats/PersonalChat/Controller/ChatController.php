<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Chats\PersonalChat\Controller;

use App\Application\Chats\PersonalChat\Command\CreateChatCommand;
use App\Domain\Bus\Command\CommandBus;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\TeacherRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ChatController extends AbstractController
{
    public function openChat(Request $request) : Response
    {



        return $this->render('chats/chat.html.twig', [
            'title' => 'ChatWindow',
        ]);
    }

}
