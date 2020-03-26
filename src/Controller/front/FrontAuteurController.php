<?php


namespace App\Controller\front;



use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FrontAuteurController extends AbstractController
{
    /**
     * @Route("/auteur", name="auteur")
     */
    public function Auteur(AuteurRepository $auteurRepository)
    {
        $auteur = $auteurRepository->findAll();
        return $this->render('front/auteur/auteur.html.twig',[
            'auteurs' => $auteur
        ]);
    }

    /**
     * @Route("/auteur/show/{id}", name="show_auteur")
     */
    public function showAuteur(AuteurRepository $auteurRepository,$id)
    {
        $auteur = $auteurRepository->find($id);
        return $this->render('front/auteur/show_auteur.html.twig',[
            'auteur' => $auteur
        ]);
    }
    /**
     * @Route("/auteurs/search", name="search_auteur")
     */
    public function searchInResume(AuteurRepository $auteurRepository,Request $request)
    {
        $search = $request->query->get('search');

        $auteur = $auteurRepository->getSearchInResume($search);

        return $this->render('front/auteur/search.html.twig',[
            'auteurs' => $auteur,
            'word' => $search
        ]);
    }
}