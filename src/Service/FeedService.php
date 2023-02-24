<?php

namespace App\Service;

use App\Entity\Feed;
use App\Repository\FeedRepository;

class FeedService
{
    private $reposotiry;

    public function __construct(FeedRepository $reposotiry)
    {
        $this->reposotiry = $reposotiry;
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
    public function createFeed(Feed $feed): void
    {
        $this->reposotiry->createFeed($feed);
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
