<?php

namespace Dudoserovich\ModifyChat\View;

use Dudoserovich\ModifyChat\Model\User;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class UserView
{
    public function render(User $user) {
        $loader = new FilesystemLoader(dirname(__DIR__, 2) . '/templates');
        $view = new Environment($loader);
        try {
            return $view->render('profile.html.twig',
                [
                    'id' => $user->getId(),
                    'login' => $user->getLogin(),
                    'password' => $user->getPassword(),
                    'logo' => $user->getLogo(),
                    'currentLink' => 'profile'
                ]
            );
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e;
        }
    }
}