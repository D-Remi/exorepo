<?php


namespace App\Controller;


use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
    */
    public function insertAuteur(Request $request,EntityManagerInterface $entityManager,AuteurRepository $auteurRepository)
    {
        $auteur = new Auteur();

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
}