<?php

namespace App\Controller;

use App\Form\Type\CallRequestType;
use App\Service\SessionService;
use App\Service\CallRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallBackController extends AbstractController
{
    /**
     * Controleur de la page d'accueil
     *
     * @param Request $request
     * @param SessionService $sessionService
     * @param CallRequestService $callRequestService
     * @return Response
     */
    public function index(Request $request, SessionService $sessionService, CallRequestService $callRequestService)
    {

        $callRequest = $sessionService->getOrCreateCallRequestSession();
        $CallRequestForm = $this->createForm(CallRequestType::class, $callRequest)->handleRequest($request);

        if($CallRequestForm->isSubmitted() && $CallRequestForm->isValid()){

            // validation of the phone number
            $callRequest = $callRequestService->validateCallRequest($callRequest);

            // save in database
            $callRequestService->save($callRequest);

            // save in session
            $sessionService->saveCallRequestSession($callRequest);

            // go to register view
            return new RedirectResponse($this->generateUrl('register'));
        }

        return $this->render('call_back/home.html.twig', [
            'current_page' => 'home',
            'callRequestForm' => $CallRequestForm->createView()

        ]);
    }

    /**
     * Controleur de la page de succes
     *
     * @param SessionService $sessionService
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
     * @param Request $request
     * @param CallRequestService $callRequestService
     * @return Response
     */
    public function listing(Request $request, CallRequestService $callRequestService)
    {
        $requests = $callRequestService->getPaginatedRequests($request->query->getInt('page',1), 3);
        return $this->render('call_back/list.html.twig', [
            'current_page' => 'list',
            'callrequests' => $requests
        ]);
    }
}
