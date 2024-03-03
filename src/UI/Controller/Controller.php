<?php

namespace App\UI\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Application\Command\SaveCreatedUserInDB;
use App\Domain\Query\GetListOfUsersQueryInterface;
use App\UI\Form\MyFormType;


#[Route('/', name: 'api_')]
class Controller extends AbstractController
{
    public function __construct(
        private SluggerInterface $slugger,
        private MessageBusInterface $messageBus,
        private GetListOfUsersQueryInterface $getListOfUsersQuery
    )
    {
    }

    #[Route('/', name: 'project_index', methods:['get'])]
    public function index(): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/form', name: 'form_page', methods:['get', 'post'])]
    public function formPage(Request $request): Response
    {
        $form = $this->createForm(MyFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $imageFile = $form->get('zalacznik')->getData();
            if($imageFile)
            {

                 $imageFile = $form->get('zalacznik')->getData();

                 $base64Image = base64_encode(file_get_contents($imageFile->getPathname()));

                
                try {
                    $this->messageBus->dispatch(new SaveCreatedUserInDB(
                        $form->get('imie')->getData(),
                        $form->get('nazwisko')->getData(),
                        $base64Image
                    ));
                }
                catch (\Exception $e) {
                    throw $e;
                }
            }

            $this->addFlash('success', 'Dane zapisano pomyślnie.');

            return $this->redirectToRoute('form_page');
        }

        return $this->render('form_page.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/list', name: 'list_of_users', methods:['get'])]
    public function listOfUsers(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $perPage = 10;

        $allUsers = $this->getListOfUsersQuery->getListOfUsers();

        $users = array_slice($allUsers, ($page - 1) * $perPage, $perPage);

        return $this->render('secured/list_of_users.html.twig', [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => ceil(count($allUsers) / $perPage),
        ]);
    }
}