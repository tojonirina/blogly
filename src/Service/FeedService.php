<?php

namespace App\Service;

use App\Entity\Feed;
use App\Event\NewFeedEvent;
use App\Repository\FeedRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FeedService
{
    private $reposotiry;
    private $dispatcher;

    public function __construct(FeedRepository $reposotiry, EventDispatcherInterface $dispatcher)
    {
        $this->reposotiry = $reposotiry;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Get all feeds
     * 
     * @return array
     */
    public function getFeeds(): array
    {
        return $this->reposotiry->getAllPublishedFeeds();
    }

    /**
     * Get all pictures of the feed
     * 
     * @return array
     */
    public function getPictures(): array
    {
        return $this->reposotiry->getPictures();
    }

    /**
     * Create a new feed
     * 
     * @param Feed $feed entity
     * @return null
     */
    public function createFeed(Feed $feed): Feed
    {
        $newFeed = $this->reposotiry->createFeed($feed);

        $this->dispatcher->dispatch(new NewFeedEvent($newFeed->getTitle()));

        return $newFeed;
    }

    /**
     * Search feed by title or description
     * 
     * @param string $search Word to search
     * @return array
     */
    public function search(string $search): array
    {
        return $this->reposotiry->search($search);
    }
}
