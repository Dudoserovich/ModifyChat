<?php

namespace Dudoserovich\ModifyChat\Controller;

use Dudoserovich\ModifyChat\Model\Message;
use Dudoserovich\ModifyChat\Model\MessageRepository;
use Dudoserovich\ModifyChat\Model\UserRepository;
use Dudoserovich\ModifyChat\View\ErrorView;
use Dudoserovich\ModifyChat\View\MessageView;

class HomeController
{
    private MessageRepository $messageRepository;
    private UserRepository $userRepository;

    public function __construct($messageRepository, $userRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }

    public function show($logo = null): string {
        $login = $_COOKIE['login'];
        $password = $_COOKIE['password'];

        $user = $this->userRepository->getByLoginPass($login, $password);

        if ($user or (empty($login) and empty($password))) {
            $messageView = new MessageView();
            $messages = $this->messageRepository->all();

            foreach ($messages as $message) {
                $messageView->addMessage($message);
            }

            return $messageView->render($logo);
        } else {
            $error = new ErrorView();
            echo $error->render("User not found", 500);
            return false;
        }

    }

    public function create($newMessage): bool
    {
        $message = new Message($newMessage['text'], $newMessage['username'], $newMessage['time']);
        $result = $this->messageRepository->add($message);

        if (!$result) {
            setcookie("typeNoty", "red");
            setcookie("messageNoty", "Ошибка при отправке сообщения");
        }

        return $result;
    }
}