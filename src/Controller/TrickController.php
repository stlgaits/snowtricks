<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tricks')]
class TrickController extends AbstractController
{
    #[Route('/{page<\d+>?1}', name: 'app_trick_index', methods: ['GET'])]
    public function index(TrickRepository $trickRepository, Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $trickRepository->getTrickPaginator($offset);

        return $this->render('trick/index.html.twig', [
            'tricks' => $paginator,
            'previous' => $offset - TrickRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + TrickRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrickRepository $trickRepository): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreatedBy($this->getUser());
            $trickRepository->add($trick);
            $this->addFlash(
                'success',
                'Trick succesfully added!'
            );

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/details/{slug}', name: 'app_trick_show', methods: ['GET'])]
    public function show(Trick $trick, Request $request, CommentRepository $commentRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($trick, $offset);
        $category = $trick->getCategory();

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'category' => $category,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new \DateTimeImmutable('now'));
            $trickRepository->add($trick);
            $this->addFlash(
                'success',
                'Trick succesfully edited!'
            );

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick);
            $this->addFlash(
                'success',
                'Trick succesfully removed!'
            );
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
