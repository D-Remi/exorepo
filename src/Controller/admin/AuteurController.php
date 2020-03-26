<?php


namespace App\Controller\admin;


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
     * @Route("/admin/auteur", name="admin_auteur")
     */
    public function Auteur(AuteurRepository $auteurRepository)
    {
        $auteur = $auteurRepository->findAll();
        return $this->render('admin/auteur/auteur.html.twig',[
            'auteurs' => $auteur
        ]);
    }

    /**
     * @Route("admin/auteur/show/{id}", name="admin_show_auteur")
     */
    public function showAuteur(AuteurRepository $auteurRepository,$id)
    {
        $auteur = $auteurRepository->find($id);
        return $this->render('admin/auteur/show_auteur.html.twig',[
            'auteur' => $auteur
        ]);
    }

    /**
    * @Route("/admin/auteurs/insert", name="admin_insert_auteur")
     * @Route("/admin/auteurs/{id}/edit", name="admin_edit_auteur")
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
     * @Route("/admin/auteur/delete/{id}", name="admin_delete_auteur")
     */
    public function deleteAuteur(AuteurRepository $auteurRepository,EntityManagerInterface $entityManager,$id){
        $auteur = $auteurRepository->find($id);

        $entityManager->remove($auteur);
        $entityManager->flush();

        return new Response('auteur suprimé');
    }

    /**
     * @Route("/admin/auteurs/search", name="admin_search_auteur")
     */
    public function searchInResume(AuteurRepository $auteurRepository,Request $request)
    {
        $search = $request->query->get('search');

        $auteur = $auteurRepository->getSearchInResume($search);

        return $this->render('admin/auteur/search.html.twig',[
            'auteurs' => $auteur,
            'word' => $search
        ]);
    }
}