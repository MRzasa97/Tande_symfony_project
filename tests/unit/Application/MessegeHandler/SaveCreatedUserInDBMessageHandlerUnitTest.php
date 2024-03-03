<?php

namespace App\Tests\Unit\Application\MessageHandler;

use PHPUnit\Framework\TestCase;
use App\Application\MessageHandler\SaveCreatedUserInDBMessageHandler;
use App\Domain\Repository\UserRepositoryInterface;
use App\Application\Command\SaveCreatedUserInDB;
use App\Tests\InMemory\UserRepositoryInMemory;
use Psr\Log\LoggerInterface;

class SaveCreatedUserInDBMessageHandlerUnitTest extends TestCase
{
    private UserRepositoryInterface $userRepository;
    private LoggerInterface $logger;
    public function SetUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepositoryInMemory();
        $this->logger = $this->createMock(LoggerInterface::class);
    }
    public function testSaveCreatedUserInDBMessageHandler()
    {
        $name = 'Jan';
        $surname = 'Kowalski';
        $base64File = 'base64File';
        $saveCreatedUserInDB = new SaveCreatedUserInDB($name, $surname, $base64File);
        $saveCreatedUserInDBMessageHandler = new SaveCreatedUserInDBMessageHandler($this->userRepository, $this->logger);
        $saveCreatedUserInDBMessageHandler($saveCreatedUserInDB);
        foreach ($this->userRepository->users as $user) {
            $this->assertEquals($name, $user->getName());
            $this->assertEquals($surname, $user->getSurname());
            $this->assertEquals($base64File, $user->getBase64File());
        }
    }
}