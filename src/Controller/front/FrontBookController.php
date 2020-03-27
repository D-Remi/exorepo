<?php


namespace App\Controller\front;


use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class FrontBookController extends AbstractController{
    /**
     * @Route("/", name="book")
     */
    public function books(BookRepository $frontbookRepository)
    {
        $books = $frontbookRepository->findby([],['id'=> 'DESC'],2,0);

        return $this->render('front/book/book.html.twig',[
            'books' => $books
        ]);
    }

    /**
     * @Route("/book/show/{id}", name="show_book")
     */
    public function showBook(BookRepository $bookRepository,$id)
    {
        $book = $bookRepository->find($id);
        return $this->render('front/book/showbook.html.twig',[
            'book' => $book
        ]);
    }

    /**
     * @Route("/book/search", name="search_book")
     */
    public function searchInResume(BookRepository $bookRepository,Request $request)
    {
        $search = $request->query->get('search');

        $books = $bookRepository->getSearchInResume($search);

        return $this->render('front/book/search.html.twig',[
            'books' => $books,
            'word' => $search
        ]);
    }
}