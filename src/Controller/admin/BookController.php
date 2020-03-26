<?php

namespace App\Controller\admin;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;

class BookController extends AbstractController
{
    /**
     * @Route("admin/book", name="admin_book")
     */
    public function books(bookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();
        return $this->render('admin/book/book.html.twig',[
            'books' => $books
        ]);
    }

    /**
     * @Route("/admin/book/show/{id}", name="admin_show_book")
     */
    public function showBook(bookRepository $bookRepository,$id)
    {
        $book = $bookRepository->find($id);
        return $this->render('admin/book/showbook.html.twig',[
            'book' => $book
        ]);
    }

    /**
     * @Route("/admin/book/insert", name="admin_insert_book")
     */

    public function insertBook(Request $request,EntityManagerInterface $entityManager)
    {
        $book = new Book();

        $form = $this->createFormBuilder($book)
                    ->add('title')
                    ->add('author')
                    ->add('resume')
                    ->add('nbpages')
                    ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book');
        }
        /**
         $title = $request->query->get('title');
        $author = $request->query->get('author');
        $resume = $request->query->get('resume');
        $nbpages = $request->query->get('nbpages');

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setResume($resume);
        $book->setNbPages($nbpages);

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('livre insérer');
         **/
        return $this->render('admin/book/insertbook.html.twig',[
            'formBook' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/book/delete/{id}", name="admin_delete_book")
     */

    public function deleteBook(EntityManagerInterface $entityManager,bookRepository $bookRepository,$id)
    {
        $book = $bookRepository->find($id);

        $entityManager->remove($book);

        $entityManager->flush();

        return new Response('livre delete');
    }

    /**
     * @Route("/admin/book/update/{id}", name="admin_update_book")
     */
    public function updateBook(EntityManagerInterface $entityManager,bookRepository $bookRepository,$id)
    {
        $book = $bookRepository->find($id);

        $book->setTitle('titre requin 2');

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('titre modifier');
    }

    /**
     * @Route("/admin/book/search", name="admin_search_book")
     */
    public function searchInResume(BookRepository $bookRepository,Request $request)
    {
        $search = $request->query->get('search');

        $books = $bookRepository->getSearchInResume($search);

        return $this->render('admin/book/search.html.twig',[
            'books' => $books,
            'word' => $search
        ]);
    }
}