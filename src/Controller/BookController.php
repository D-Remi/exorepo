<?php

namespace App\Controller;

use App\Repository\BookRepository;
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
}