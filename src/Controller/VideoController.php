<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use App\Service\EmbedVideoLink\VideoLinkSorterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/video')]
class VideoController extends AbstractController
{
    #[Route('/', name: 'app_video_index', methods: ['GET'])]
    public function index(VideoRepository $videoRepository): Response
    {
        return $this->render('video/index.html.twig', [
            'videos' => $videoRepository->findAll(),
        ]);
    }

    #[Route('/{trick}', name: 'app_video_index_per_trick', methods: ['GET'])]
    public function showByTrick(Trick $trick, VideoRepository $videoRepository): Response
    {
        return $this->render('video/index.html.twig', [
            'videos' => $videoRepository->findBy(['trick' => $trick->getId()]),
            'trick' => $trick,
        ]);
    }

    #[Route('/{trick}/new', name: 'app_video_new', methods: ['GET', 'POST'])]
    public function new(Trick $trick, Request $request, VideoRepository $videoRepository, VideoLinkSorterService $videoLinkTrimmer): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // casts the submitted link into an embed link
            $link = $videoLinkTrimmer->trimUrl($form->get('link')->getData());
            $video->setLink($link);
            $video->setTrick($trick);
            $videoRepository->add($video);

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video/new.html.twig', [
            'video' => $video,
            'form' => $form,
            'trick' => $trick,
        ]);
    }

    #[Route('/{id}', name: 'app_video_show', methods: ['GET'])]
    public function show(Video $video): Response
    {
        return $this->render('video/show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/{id}', name: 'app_video_delete', methods: ['POST'])]
    public function delete(Request $request, Video $video, VideoRepository $videoRepository): Response
    {
        $trick = $video->getTrick();
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) {
            $videoRepository->remove($video);
        }

        return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
    }
}
