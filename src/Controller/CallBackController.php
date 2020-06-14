<?php

namespace App\Controller;

use App\Service\SessionService;
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
        return $this->render('call_back/home.html.twig', ['current_page' => 'home' ]);
    }

    /**
     * Controleur de la page de succes
     *
     * @return Response
     */
    public function register(SessionService $sessionService)
    {
        $callRequest = $sessionService->getCallRequestSession();

        // pour éviter le rechargement de la page
        $sessionService->deleteCallRequestInSession();

        return $this->render('call_back/register.html.twig', [
            'current_page' => 'register',
            'callrequest' => $callRequest
        ]);
    }

    /**
     * Controleur de la page de listing
     *
     * @return Response
     */
    public function listing()
    {
        return $this->render('call_back/list.html.twig', ['current_page' => 'list' ]);
    }
}
