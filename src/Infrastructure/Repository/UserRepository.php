<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $_em
        )
    {
    }

    public function saveUser(string $name, string $surname, string $base64File): void
    {
        $user = new User();
        $user->setName($name);
        $user->setSurname($surname);
        $user->setBase64File($base64File);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
