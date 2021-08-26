<?php

namespace App\Controller\NoAuth;

use App\Entity\Users;
use App\Service\UsersService;
use App\Repository\UsersRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/user')]
class UsersController extends AbstractController
{
    private $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    #[Route('/{token}', name: 'users_token', methods: ['OPTIONS', 'POST', 'GET'])]
    public function getByToken(): JsonResponse
    {
        /*dd('here');
        $users = $this->usersService->findAllExceptCurrent($this->getUser());
*/
        return new JsonResponse([], 200);
    }
}
