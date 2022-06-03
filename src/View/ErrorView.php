<?php

namespace Dudoserovich\ModifyChat\View;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class ErrorView
{
    public function render(string $errorMessage, int $statusCode)
    {
        $loader = new FilesystemLoader(dirname(__DIR__, 2) . '/templates');
        $view = new Environment($loader);
        try {
            return $view->render('error.html.twig', ['message' => $errorMessage, 'statusCode' => $statusCode]);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e;
        }
    }
}