<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Website;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends Controller
{
    /**
     * @Route("/websites", name="website_list")
     */
    public function listAction()
    {
        // Get Books
        $websites = $this->getDoctrine()->getRepository(Website::class)
            ->findAll();

        // Count Books
        $websiteNbre = count($websites);
        $websiteNbre = $websiteNbre <= 1 ? $websiteNbre . ' site' : $websiteNbre . ' sites';

        return $this->render('website/list.html.twig', [
            'websites' => $websites,
            'websiteNbre' => $websiteNbre
        ]);
    }
}
