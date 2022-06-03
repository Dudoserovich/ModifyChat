<?php

namespace Dudoserovich\ModifyChat\Controller;

use Dudoserovich\ModifyChat\Model\Hash;
use Dudoserovich\ModifyChat\Model\User;
use Dudoserovich\ModifyChat\Model\UserRepository;
use Dudoserovich\ModifyChat\View\ErrorView;
use Dudoserovich\ModifyChat\View\UserView;

class UserController
{
    private UserRepository $userRepository;

    public function __construct($repository)
    {
        $this->userRepository = $repository;
    }

    public function showProfile(): bool
    {
        $userView = new UserView();
        $login = $_COOKIE['login'];
        $password = $_COOKIE['password'];
        $user = $this->userRepository->getByLoginPass($login, $password);

        if ($user) {
            echo $userView->render($user);
            return true;
        } else {
            $error = new ErrorView();
            echo $error->render("User not found", 500);
            return false;
        }
    }

    public function editProfile($user)
    {
        $checkLogin = strlen($user['username']) >= 2 && strlen($user['password']) <= 32;
        $checkOldPassword = strlen($user['old-password']) >= 5 && strlen($user['old-password']) <= 64;
        $checkNewPassword = strlen($user['new-password']) >= 5 && strlen($user['new-password']) <= 64;

        if (!$checkLogin || !$checkOldPassword || !$checkNewPassword) {
            setcookie("typeNoty", "warning");
            setcookie("messageNoty", "Incorrect fields were entered during editing");
        } else {
            if (Hash::pw_check($user['old-password'], $this->userRepository->getByLogin($user['username'])->getPassword())) {
                $user = new User($user['username'], $user['new-password'], $user['id']);
                $newUser = $this->userRepository->editUser($user);

                if (!$newUser) {
                    setcookie("typeNoty", "warning");
                    setcookie("messageNoty", "The user has been changed. Perhaps a user with this login already exists");
                } else {
                    setcookie('login', $newUser->getLogin(), array('httponly' => true));
                    setcookie('password', $newUser->getPassword(), array('httponly' => true));

                    setcookie("typeNoty", "green");
                    setcookie("messageNoty", "Data changed successfully");
                }
            } else {
                setcookie("typeNoty", "warning");
                setcookie("messageNoty", "Wrong old password");
            }
        }

        exit(header("Location: /ModifyChat/profile"));
    }

    public function logIn($user)
    {
        if ($user['username'] == '' || $user['password'] == '') {
            setcookie("typeNoty", "warning");
            setcookie("messageNoty", "Empty fields were entered during authorization");
        } else {
            $user = new User($user['username'], $user['password']);
            $userLogIn = $this->userRepository->logIn($user);

            if ($userLogIn) {
                setcookie('login', $userLogIn->getLogin(), array('httponly' => true));
                setcookie('password', $userLogIn->getPassword(), array('httponly' => true));
            } else {
                setcookie("typeNoty", "warning");
                setcookie("messageNoty", "Wrong login or password");
            }
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }

    public function signUp($user)
    {
        if (isset($_POST['reg'])) {
            $checkLogin = strlen($user['username']) >= 2 && strlen($user['password']) <= 32;
            $checkPassword = strlen($user['password']) >= 5 && strlen($user['password']) <= 64;
            $checkRePassword = $user['password'] == $user['re-password'];

            if (!$checkLogin || !$checkPassword || !$checkRePassword) {
                setcookie("typeNoty", "warning");
                setcookie("messageNoty", "Incorrect fields were entered during registration");
            } else {
                $user = new User($user['username'], $user['password']);
                $userSignUp = $this->userRepository->signUp($user);

                if ($userSignUp) {
                    setcookie('login', $userSignUp->getLogin(), array('httponly' => true));
                    setcookie('password', $userSignUp->getPassword(), array('httponly' => true));
                } else {
                    setcookie("typeNoty", "warning");
                    setcookie("messageNoty", "User with this login already exists");
                }
            }

            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }

    public function getLogo($login)
    {
        $user = $this->userRepository->getByLogin($login);

        if ($user)
            return $user->getLogo();
        else return $user;
    }

    public function logOut()
    {
        setcookie('login', '', time() - 3600);
        setcookie('password', '', time() - 3600);

        header('Location: ' . parse_url($_SERVER['REQUEST_URI'])['path']);
    }
}