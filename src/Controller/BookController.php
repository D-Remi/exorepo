<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="book")
     */
    public function books(bookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();
        return $this->render('book.html.twig',[
            'books' => $books
        ]);
    }

    /**
     * @Route("book/{id}", name="showbook")
     */
    public function showBook(bookRepository $bookRepository,$id)
    {
        $book = $bookRepository->find($id);
        return $this->render('showbook.html.twig',[
            'book' => $book
        ]);
    }

    /**
     * @Route("insert", name="insert_book")
     */

    public function insertBook(EntityManagerInterface $entityManager,Request $request)
    {
        $title = $request->query->get('title');
        $author = $request->query->get('author');
        $resume = $request->query->get('resume');
        $nbpages = $request->query->get('nbpages');

        $book = new Book();

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setResume($resume);
        $book->setNbPages($nbpages);


        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('livre insérer');
    }

    /**
     * @Route("delete/{id}", name="delete_book")
     */

    public function deleteBook(EntityManagerInterface $entityManager,bookRepository $bookRepository,$id)
    {
        $book = $bookRepository->find($id);

        $entityManager->remove($book);

        $entityManager->flush();

        return new Response('livre delete');
    }
}