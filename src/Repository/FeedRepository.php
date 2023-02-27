<?php

namespace App\Repository;

use App\Entity\Feed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Feed>
 *
 * @method Feed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feed[]    findAll()
 * @method Feed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedRepository extends ServiceEntityRepository
{
    private $entityManager;


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feed::class);

        $this->initEntitymanager();
    }

    /**
     * Get all pictures of the feed
     * 
     * @return array
     */
    public function getPictures(): array
    {
        return $this->createQueryBuilder('feed')
            ->orderBy('feed.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    private function initEntitymanager()
    {
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * Create a new feed
     * 
     * @param Feed $feed entity
     * @return Feed
     */
    public function createFeed(Feed $feed): Feed
    {
        $this->entityManager->persist($feed);
        $this->entityManager->flush();

        return $feed;
    }

    /**
     * Delete a feed
     * 
     * @param Feed $feed entity
     * @return null
     */
    public function remove(Feed $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Get all feed
     * 
     * @return array
     */
    public function getAllPublishedFeeds(): array
    {
        return $this->createQueryBuilder('feed')
            ->orderBy('feed.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Search feed by title or description
     * 
     * @param string $search Word to search
     * @return array
     */
    public function search(string $search): array
    {
        return $this->createQueryBuilder('feed')
            ->where('feed.title LIKE :search')
            ->orWhere('feed.description LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('feed.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Feed[] Returns an array of Feed objects
     */
    // public function findByExampleField($value): array
    // {
    //     return $this->createQueryBuilder('f')
    //         ->andWhere('f.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('f.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult();
    // }

    // public function findOneBySomeField($value): ?Feed
    // {
    //     return $this->createQueryBuilder('f')
    //         ->andWhere('f.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult();
    // }
}
