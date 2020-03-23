<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="book")
     */
    public function books(bookRepository $bookrepository)
    {
        $books = $bookrepository->findall();
        return $this->render('book.html.twig',[
            'books' => $books
        ]);
    }

    /**
     * @Route("book/{id}", name="showbook")
     */
    public function showBook(Book $books)
    {
        return $this->render('showbook.html.twig',[
            'book' => $books
        ]);
    }
}