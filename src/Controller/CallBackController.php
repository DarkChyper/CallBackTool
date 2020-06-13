<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CallBackController extends AbstractController
{
    /**
     * Controleur de la page d'accueil
     *
     * @return Response
     */
    public function index()
    {
        return $this->render('call_back/home.html.twig');
    }

    /**
     * Controleur de la page de succes
     *
     * @return Response
     */
    public function register()
    {
        return $this->render('call_back/register.html.twig');
    }

    /**
     * Controleur de la page de listing
     *
     * @return Response
     */
    public function listing()
    {
        return $this->render('call_back/list.html.twig');
    }
}
