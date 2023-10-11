<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * Permet d'afficher l'ensemble des annonces du site
     *
     * @param AdRepository $repo
     * @return Response
     */
    #[Route('/ads', name: 'ads_index')]
    public function index(AdRepository $repo): Response
    {
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Permet d'afficher une annonce 
     * 
     * @param string $slug
     * @param Ad $ad
     * @return Response
     */

    #[Route("/ads/new", name: "ads_create")]
    public function create(): Response
    {

        $ad = new Ad();
        $form = $this->createForm(AnnonceType::class, $ad);

        return $this->render("ad/new.html.twig", [
            // myForm = formulaire
            "myForm" => $form->createView()
        ]);
    }
}
