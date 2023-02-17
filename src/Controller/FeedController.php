<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route('/feed', name="blogly_")
 */
class FeedController extends AbstractController
{
    /**
     * @Route("/", name="post_feed", methods={"POST"})
     */
    public function postFeed(Request $request): Response
    {
        $title = $request->request->get('title');
        $description = $request->request->get('description');
        $description = $request->files->get('image');
        
        $this->addFlash('notice', ['success' => 'Feed posted successfully']);

        return $this->redirectToRoute('blogly_index');
    }
}
