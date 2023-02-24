<?php

namespace App\Controller;

use App\Entity\Feed;
use App\Service\FeedService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/feeds", name: "blogly_")]
class FeedController extends AbstractController
{
    private $feedService;

    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    #[Route("/{id}", name: "feed_show", requirements: ["id" => "\d+"], methods: ["GET"])]
    public function show(Feed $feed): Response
    {
        return $this->render('feed/show.html.twig', ['feed' => $feed]);
    }

    #[Route("/search", name: "feed_search", methods: ["GET"])]
    public function search(Request $request): Response
    {
        $founded_feed = $this->feedService->search($request->query->get('q'));

        return $this->render('feed/search.html.twig', ['founded_feed' => $founded_feed]);
    }

    #[Route('/pictures', name: "feed_pictures")]
    public function getPictures()
    {
        $pictures = $this->feedService->getPictures();

        return $this->render('picture/list.html.twig', ['pictures' => $pictures]);
    }
}
