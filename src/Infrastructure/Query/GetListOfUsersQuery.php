<?php

namespace App\Infrastructure\Query;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Entity\User;
use App\Domain\Query\GetListOfUsersQueryInterface;
use Psr\Log\LoggerInterface;

class GetListOfUsersQuery implements GetListOfUsersQueryInterface
{
    public function __construct(
        private EntityManagerInterface $_em,
        private LoggerInterface $logger
    )
    {
    }

    public function getListOfUsers(): array
    {
        $this->logger->info('Getting list of users...');
        
        $listOfUsers = $this->_em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->getQuery()
            ->getResult();

        $this->logger->info('List of users retrieved');

        return $listOfUsers;
    }
}