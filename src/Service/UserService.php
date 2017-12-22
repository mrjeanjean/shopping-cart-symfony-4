<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class UserService
{
    protected $database;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public function saveUser($user){

        $this->database->executeQuery(
            "INSERT INTO user (FirstName, LastName, Email, Password, Address, City, ZipCode, Country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            array(
                $user['firstname'],
                $user['lastname'],
                $user['email'],
                $user['password'],
                $user['address'],
                $user['city'],
                $user['zip'],
                "France"
            )
        );

        return $this->database->lastInsertId();
    }
}