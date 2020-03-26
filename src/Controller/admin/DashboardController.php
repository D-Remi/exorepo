<?php


namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin" , name="admin")
     */
    public function dashboardAdmin(){
        return $this->render('admin/dashboard.html.twig');
    }
}