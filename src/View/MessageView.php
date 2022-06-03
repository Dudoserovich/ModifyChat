<?php

namespace Dudoserovich\ModifyChat\View;

use Dudoserovich\ModifyChat\Model\Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class MessageView
{
    private array $messages = [];

    public function addMessage(Message $message) {
        $this->messages[] = $message;
    }

    public function render($logo = null) {
        $loader = new FilesystemLoader(dirname(__DIR__, 2) . '/templates');
        $view = new Environment($loader);
        try {
            return $view->render('index.html.twig',
                [
                    'messages' => $this->messages ?? array(),
                    'login' => $_COOKIE['login'],
                    'currentLink' => 'home',
                    'logo' => $logo
                ]
            );
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e;
        }
    }
}