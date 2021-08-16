<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Manga;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Manga|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manga|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manga[]    findAll()
 * @method Manga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    public function getMangaUser($user){
        $query = $this->createQueryBuilder('manga')
            ->select('manga')
            ->join('manga.user', 'user')
            ->where('user.username LIKE :username')
            ->setParameter('username', $user);

        return $query->getQuery()->getResult();
    }

    /**
     * Returns the research results
     * @return \App\Entity\Manga[]
     */
    public function findSearch(SearchData $search, string $username): array {

        $query = $this->createQueryBuilder('manga')
            ->select('status', 'manga')
            ->join('manga.status', 'status')
            ->join('manga.user', 'user')
            ->where('user.username LIKE :user')
            ->setParameter('user', $username);

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('manga.title LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        if (!empty($search->rating)) {
            $query = $query
                ->andWhere('manga.rating = :rating')
                ->setParameter('rating', $search->rating);
        }
        if (!empty($search->status)) {
            $query = $query
                ->andWhere('status.id IN (:status)')
                ->setParameter('status', $search->status);
        }
        return $query->getQuery()->getResult();
    }


    public function findHighestMangas(){
        $highestRankedManga = [];

        $query = $this->createQueryBuilder('manga')
            ->select('manga')
            ->where('manga.rating' >=7);

        return $highestRankedManga;
    }
}
