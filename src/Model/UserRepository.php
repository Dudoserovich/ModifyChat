<?php

namespace Dudoserovich\ModifyChat\Model;

use PDO;

class UserRepository
{
    private PDO $PDO;

    public function __construct(PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    public function logIn(User $user): ?User
    {
        $result = $this->getByLogin($user->getLogin());

        if ($result and Hash::pw_check($user->getPassword(), $result->getPassword()))
            return $result;
        else return null;
    }

    public function getByLoginPass($login, $pass): ?User
    {
        $query = $this->PDO->prepare('SELECT * from users where login=?');
        $query->execute([$login]);
        $foundTask = $query->fetch();

        if (!$foundTask or !(strncmp($pass, $foundTask['password'], 50) === 0)) {
            return null;
        } else return
            new User(
                $foundTask['login'],
                $foundTask['password'],
                $foundTask['id'],
                $foundTask['logo']
            );
    }

    public function signUp(User $user): ?User
    {
        if ($this->getByLogin($user->getLogin())) {
            return null;
        } else {
            $this->noReturnRequest(
                'INSERT INTO users(login,password,logo) VALUES(:username,:password,:logo)',
                [
                    'username' => $user->getLogin(),
                    'password' => Hash::pw_encode($user->getPassword()),
                    'logo' => $user->getLogo()
                ]
            );
            return $this->getByLogin($user->getLogin());
        }
    }

    public function getByLogin($login): ?User
    {
        $query = $this->PDO->prepare('SELECT * from users where login=?');
        $query->execute([$login]);
        $foundTask = $query->fetch();

        if (!$foundTask)
            return null;

        else return
            new User(
                $foundTask['login'],
                $foundTask['password'],
                $foundTask['id'],
                $foundTask['logo']
            );
    }

    private function noReturnRequest(string $sql, $bindings = [])
    {
        $query = $this->PDO->prepare($sql);
        $query->execute($bindings);
    }

    public function editUser(User $newUser): ?User
    {
        $previousUser = $this->getById($newUser->getId());

        if ($previousUser->getLogin() == $newUser->getLogin() and Hash::pw_check($newUser->getPassword(), $previousUser->getPassword()))
            return null;
        else {
            $byLoginUser = $this->getByLogin($newUser->getLogin());
            if (!$byLoginUser or $newUser->getId() == $byLoginUser->getId()) {
                $this->noReturnRequest(
                    'UPDATE users set login=:login,password=:password WHERE id=:id',
                    [
                        'id' => $newUser->getId(),
                        'login' => $newUser->getLogin(),
                        'password' => Hash::pw_encode($newUser->getPassword())
                    ]
                );

                // тут ещё нужно обновлять все сообщения пользователя
                $messagesUser = new MessageRepository($this->PDO, $this);
                $messagesUser->updateMessagesUser($newUser->getLogin(), $previousUser->getLogin());

                return $this->getById($newUser->getId());
            } else return null; // если пользователь с таким логином уже существует, то не обновляем и выкидываем ошибку
        }
    }

    public function getById($id): ?User
    {
        $query = $this->PDO->prepare('SELECT * from users where id=?');
        $query->execute([$id]);
        $foundTask = $query->fetch();

        if (!$foundTask)
            return null;

        else return
            new User(
                $foundTask['login'],
                $foundTask['password'],
                $foundTask['id']
            );
    }
}