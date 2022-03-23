<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        throw new \Exception('logout() should never be reached');
    }

}
