<?php

namespace Dudoserovich\ModifyChat\Model;

use PDO;

class MessageRepository
{
    private PDO $PDO;
    private UserRepository $userRepository;

    public function __construct(PDO $PDO, $userRepository)
    {
        $this->PDO = $PDO;
        $this->userRepository = $userRepository;
    }

    public function add(Message $message): bool
    {
        if ($this->userRepository->getByLogin($message->getUsername())) {
            $taskByFields = $this->getByFields($message->getUsername(), $message->getText(), $message->getTime());

            if (!$taskByFields) {
                $this->noReturnRequest(
                    'INSERT INTO messages(username,text,datetime) VALUES(:username,:text,:datetime)',
                    [
                        'username' => $message->getUsername(),
                        'text' => $message->getText(),
                        'datetime' => $message->getTime()
                    ]
                );
                return true;
            } else return false;
        } else return false;
    }

    public function getByFields($username, $text, $datetime): ?Message
    {
        $foundTask = $this->returnOneRequest(
            'SELECT * from messages where username=:username AND text=:text AND datetime=:datetime',
            [
                'username' => $username,
                'text' => $text,
                'datetime' => $datetime
            ]
        );

        if (!$foundTask)
            return null;
        else return new Message($foundTask['text'], $foundTask['username'], $foundTask['datetime']);
    }

    private function returnOneRequest(string $sql, $bindings = [])
    {
        $query = $this->PDO->prepare($sql);
        $query->execute($bindings);
        return $query->fetch();
    }

    private function noReturnRequest(string $sql, $bindings = [])
    {
        $query = $this->PDO->prepare($sql);
        $query->execute($bindings);
    }

    /**
     * @return Message[]
     */
    public function all(): array
    {
        $messages = [];

        $rows = $this->returnAllRequest('SELECT * from messages');

        foreach ($rows as $row) {
            $message = new Message(
                $row['text'],
                $row['username'],
                $row['datetime']
            );
            $messages[] = $message;
        }

        return $messages;
    }

    private function returnAllRequest(string $sql, array $bindings = [])
    {
        $statement = $this->PDO->prepare($sql);
        $statement->execute($bindings);
        return $statement->fetchAll();
    }

    public function updateMessagesUser($newUsername, $oldUsername)
    {
        $this->noReturnRequest(
            'UPDATE messages set username=:newUsername WHERE username=:oldUsername',
            [
                'newUsername' => $newUsername,
                'oldUsername' => $oldUsername
            ]
        );
    }
}