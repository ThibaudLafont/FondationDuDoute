<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends Controller
{
    /**
     * @Route("/books", name="book_list")
     */
    public function listAction()
    {
        // Get Books
        $books = $this->getDoctrine()->getRepository(Book::class)
            ->findAll();

        // Count Books
        $bookNbre = count($books);
        $bookNbre = $bookNbre <= 1 ? $bookNbre . ' livre' : $bookNbre . ' livres';

        return $this->render('book/list.html.twig', [
            'books' => $books,
            'bookNbre' => $bookNbre
        ]);
    }
}
