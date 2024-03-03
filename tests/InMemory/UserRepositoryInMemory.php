<?php

namespace App\Tests\InMemory;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;

class UserRepositoryInMemory implements UserRepositoryInterface
{
    public array $users = [];

    public function __construct()
    {
    }

    public function saveUser(string $name, string $surname, string $base64File): void
    {
        $user = new User();
        $user->setName($name);
        $user->setSurname($surname);
        $user->setBase64File($base64File);
        $this->users[] = $user;
    }
}