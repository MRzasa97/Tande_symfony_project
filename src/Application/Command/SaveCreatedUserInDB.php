<?php

namespace App\Application\Command;

use App\Application\ExternalMessage;

class SaveCreatedUserInDB implements ExternalMessage
{
    private string $name;
    private string $surname;
    private string $base64File;

    public function __construct(
        string $name,
        string $surname,
        string $base64File
    )
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->base64File = $base64File;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getBase64File(): string
    {
        return $this->base64File;
    }
}