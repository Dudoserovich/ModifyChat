<?php

namespace Dudoserovich\ModifyChat\Model;

class User
{
    private ?int $id;
    private string $login;
    private string $password;
    private string $logo;

    public function __construct($login, $password, $id=null, $logo = "")
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->logo = $logo!="" ? $logo : "https://avatars.dicebear.com/api/avataaars/" .
            $login .
            ".svg?background=%23e6e6fa&size=40&radius=50";
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }
}