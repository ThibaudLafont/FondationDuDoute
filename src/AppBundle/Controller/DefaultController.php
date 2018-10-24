<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Post;
use AppBundle\Entity\Website;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Get number of books
        $bookNbre = count($em->getRepository(Book::class)
            ->findAll());
        $bookNbre = $bookNbre >= 1 ? $bookNbre . ' livre' : $bookNbre . ' livres';

        // Get number of posts
        $postNbre = count($em->getRepository(Post::class)
            ->findAll());
        $postNbre = $postNbre >= 1 ? $postNbre . ' fiche' : $postNbre . ' fiches';

        // Get number of websites
        $websiteNbre = count($em->getRepository(Website::class)
            ->findAll());
        $websiteNbre = $websiteNbre >= 1 ? $websiteNbre . ' site' : $websiteNbre . ' sites';

        // replace this example code with whatever you need
        return $this->render('default/homepage.html.twig', [
            'bookNbre' => $bookNbre,
            'postNbre' => $postNbre,
            'websiteNbre' => $websiteNbre
        ]);
    }
}
