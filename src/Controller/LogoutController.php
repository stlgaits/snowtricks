<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        $this->addFlash(
            'success',
            'Successfully logged out.'
        );
        throw new \Exception('logout() should never be reached');
    }
}
