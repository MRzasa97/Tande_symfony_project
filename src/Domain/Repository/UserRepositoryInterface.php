<?php

namespace App\Domain\Repository;

interface UserRepositoryInterface
{
    public function saveUser(string $name, string $surname, string $base64File): void;
}