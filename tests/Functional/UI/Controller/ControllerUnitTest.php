<?php

namespace App\Tests\Funtional\UI\Controller;

use App\UI\Controller\Controller;
use App\Domain\Query\GetListOfUsersQueryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ControllerUnitTest extends WebTestCase
{
    public function testFormPageIfImageIsLessThen2MB()
    {
        $client = static::createClient();

        $uploadedFile = 'tests/testFiles/IMG_20230703_103653060.jpg';

        $crawler = $client->request('GET', '/form');
        $form = $crawler->selectButton('Wyślij')->form();

        $form['my_form[imie]'] = 'Jan';
        $form['my_form[nazwisko]'] = 'Kowalski';
        $form['my_form[zalacznik]'] = new UploadedFile($uploadedFile, 'IMG_20230703_103653060.jpg', 'image/jpeg');

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('.alert-success', 'Dane zapisano pomyślnie.');
    }

    public function testFormPageIfImageIsMoreThen2MB()
    {
        $client = static::createClient();

        $uploadedFile = 'tests/testFiles/IMG_20230705_131711824.jpg';

        $crawler = $client->request('GET', '/form');
        $form = $crawler->selectButton('Wyślij')->form();

        $form['my_form[imie]'] = 'Jan';
        $form['my_form[nazwisko]'] = 'Kowalski';
        $form['my_form[zalacznik]'] = new UploadedFile($uploadedFile, 'IMG_20230703_103653060.jpg', 'image/jpeg');

        $client->submit($form);

        $this->assertResponseIsSuccessful();

        $this->assertSelectorNotExists('.alert-success');
    }
}
