<?php

namespace Dudoserovich\ModifyChat\Controller;
use Dudoserovich\ModifyChat\View\ErrorView;

class ErrorController
{
    public function show(string $errorMessage, int $statusCode): string
    {
        $notFound = new ErrorView();
        http_response_code($statusCode);
        return $notFound->render($errorMessage, $statusCode);
    }
}