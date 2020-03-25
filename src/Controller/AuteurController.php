<?php


namespace App\Controller;


use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuteurController extends AbstractController
{
    /**
     * @Route("/auteur", name="auteur")
     */
    public function Auteur(AuteurRepository $auteurRepository)
    {
        $auteur = $auteurRepository->findAll();
        return $this->render('auteur/auteur.html.twig',[
            'auteurs' => $auteur
        ]);
    }

    /**
     * @Route("auteur/{id}", name="show_auteur")
     */
    public function showAuteur(AuteurRepository $auteurRepository,$id)
    {
        $auteur = $auteurRepository->find($id);
        return $this->render('auteur/show_auteur.html.twig',[
            'auteur' => $auteur
        ]);
    }

    /**
    * @Route("/auteurs/insert", name="insert_auteur")
     * @Route("/auteurs/{id}/edit", name="edit_auteur")
     *
    */
    public function insertAuteur(Request $request,EntityManagerInterface $entityManager,Auteur $auteur = null)
    {
        if(!$auteur){
            $auteur = new Auteur();
        }

        $form = $this->createFormBuilder($auteur)
            ->add('name')
            ->add('firstname')
            ->add('birthDate', DateType::class)
            ->add('deathDate', DateType::class)
            ->add('biography')
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($auteur);
            $entityManager->flush();

            return new Response('auteur creer');
        }

        return $this->render('auteur/insert_auteur.html.twig',[
            'formAuteur' => $form->createView()
        ]);
    }
    /**
     * @Route("/auteur/delete/{id}", name="delete_auteur")
     */
    public function deleteAuteur(AuteurRepository $auteurRepository,EntityManagerInterface $entityManager,$id){
        $auteur = $auteurRepository->find($id);

        $entityManager->remove($auteur);
        $entityManager->flush();

        return new Response('auteur suprimé');
    }

    /**
     * @Route("auteurs/search", name="search_auteur")
     */

    public function searchInResume(AuteurRepository $auteurRepository,Request $request)
    {
        $search = $request->query->get('search');

        $auteur = $auteurRepository->getSearchInResume($search);

        return $this->render('/auteur/search.html.twig',[
            'auteurs' => $auteur,
            'word' => $search
        ]);
    }
}