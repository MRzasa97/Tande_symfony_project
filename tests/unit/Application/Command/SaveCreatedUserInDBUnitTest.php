<?php

namespace App\Tests\Unit\Application\Command;

use PHPUnit\Framework\TestCase;
use App\Application\Command\SaveCreatedUserInDB;

class SaveCreatedUserInDBUnitTest extends TestCase
{
    public function testSaveCreatedUserInDB()
    {
        $name = 'Jan';
        $surname = 'Kowalski';
        $base64File = 'base64File';
        $saveCreatedUserInDB = new SaveCreatedUserInDB($name, $surname, $base64File);
        $this->assertEquals($name, $saveCreatedUserInDB->getName());
        $this->assertEquals($surname, $saveCreatedUserInDB->getSurname());
        $this->assertEquals($base64File, $saveCreatedUserInDB->getBase64File());
    }
}