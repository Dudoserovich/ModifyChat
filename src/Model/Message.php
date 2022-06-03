<?php

namespace Dudoserovich\ModifyChat\Model;

class Message
{
    private string $text;
    private string $username;
    private string $time;

    public function __construct($text, $username, $time)
    {
        $this->text = $text;
        $this->username = $username;
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

}