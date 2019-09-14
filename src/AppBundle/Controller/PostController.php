<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    /**
     * @Route("/posts", name="post_list")
     */
    public function listAction()
    {
        // Get Books
        $posts = $this->getDoctrine()->getRepository(Post::class)
            ->findBy([], ['title' => 'ASC']);

        // Count Books
        $postNbre = count($posts);
        $postNbre = $postNbre <= 1 ? $postNbre . ' fiche' : $postNbre . ' fiches';

        return $this->render('post/list.html.twig', [
            'posts' => $posts,
            'postNbre' => $postNbre
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_show")
     */
    public function showAction($id)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)
            ->find($id);

        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }
}
