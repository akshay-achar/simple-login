<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends AbstractController
{

    public function homepage(Request $request)
    {
        return $this->render('admin/homepage.html.twig');
    }



}