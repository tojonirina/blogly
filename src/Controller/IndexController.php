<?php

namespace App\Controller;

use App\Entity\Feed;
use App\Form\PostFeedFormType;
use App\Service\FeedService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class IndexController extends AbstractController
{
    private $feedService;

    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    #[Route("/", name: "blogly_index", methods: ["GET", "HEAD", "POST"])]
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $feed = new Feed();
        $newFeedForm = $this->createForm(PostFeedFormType::class, $feed);
        $newFeedForm->handleRequest($request);

        if (
            $newFeedForm->isSubmitted() &&
            $newFeedForm->isValid()
        ) {
            $image = $newFeedForm->get('image')->getData();

            // For the image
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('notice', ['type' => 'danger', 'message' => $e->getMessage()]);
                    return $this->redirectToRoute('blogly_index');
                }

                $feed->setImage($newFilename);
            }
            // For all other fields
            $feed->setTitle($newFeedForm->get('title')->getData());
            $feed->setDescription($newFeedForm->get('description')->getData());
            $feed->setUserId(1);

            // Call feed service to create feed
            try {
                $this->feedService->createFeed($feed);

                $this->addFlash('notice', ['type' => 'success', 'message' => 'Feed created successfully']);
                return $this->redirectToRoute('blogly_index');
            } catch (\Throwable $th) {
                $this->addFlash('notice', ['type' => 'danger', 'message' => $th->getMessage()]);
                return $this->redirectToRoute('blogly_index');
            }
        }

        return $this->renderForm('index/index.html.twig', ['new_feed_form' => $newFeedForm, 'feeds' => $this->feedService->getFeeds()]);
    }
}
