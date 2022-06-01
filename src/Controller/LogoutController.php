<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function logout(TranslatorInterface $translator)
    {
        $this->addFlash(
            'success',
            $translator->trans('logout')
        );
        throw new \Exception('logout() should never be reached');
    }
}
