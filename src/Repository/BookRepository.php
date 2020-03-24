<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getSearchInResume(){

        $search = 'requin';

        $queryBuilder = $this->createQueryBuilder('book');

        $query = $queryBuilder->select('book')
            ->where('book.title LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery();

        $result = $query->getResult();

        return $result;
    }
}
