<?php


namespace App\EventListener;


use App\Exception\CallAPIException;
use App\Exception\CallRequestSessionException;
use App\Service\MessageFlashService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

use Symfony\Component\Routing\RouterInterface;

class CBRExceptionListener
{
    private $_router;
    private $_mfs;

    /**
     * CBRExceptionListener constructor.
     * @param RouterInterface $router
     * @param MessageFlashService $mfs
     */
    public function __construct(RouterInterface $router, MessageFlashService $mfs)
    {
        $this->_router = $router;
        $this->_mfs = $mfs;
    }

    public function onKernelException(ExceptionEvent $event){
        // You get the exception object from the received event
        $exception = $event->getThrowable();

        if ($exception instanceof CallRequestSessionException) {
            $event->setResponse($this->catchException('homepage'));
        }elseif ($exception instanceof CallAPIException) {
            $event->setResponse($this->catchException('homepage',$exception->getPrevious() . " ||| " . $exception->getMessage()));
        } else {
            return false;
        }
    }

    /**
     * @param $route
     * @param null $message
     * @return RedirectResponse
     */
    private function catchException($route, $message=null){
        if($message !== null){
            $this->_mfs->messageError($message);
        }
        return new RedirectResponse($this->_router->generate($route));
    }
}