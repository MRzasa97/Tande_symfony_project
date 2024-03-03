<?php

namespace App\Application\MessageHandler;

use App\Application\Command\SaveCreatedUserInDB;
use App\Domain\Repository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

#[AsMessageHandler]
class SaveCreatedUserInDBMessageHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger
    )
    {
    }
    public function __invoke(SaveCreatedUserInDB $message)
    {
        $this->logger->info('Saving user in DB...');

        $this->userRepository->saveUser($message->getName(), $message->getSurname(), $message->getBase64File());
        
        $this->logger->info('User saved in DB');
    }
}