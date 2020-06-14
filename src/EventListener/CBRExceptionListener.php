<?php


namespace App\EventListener;


use App\Exception\CallRequestSessionException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

use Symfony\Component\Routing\RouterInterface;

class CBRExceptionListener
{
    private $_router;

    /**
     * CBRExceptionListener constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->_router = $router;
    }

    public function onKernelException(ExceptionEvent $event){
        // You get the exception object from the received event
        $exception = $event->getThrowable();

        if ($exception instanceof CallRequestSessionException) {
            $event->setResponse($this->catchException('homepage'));
        }else {
            return false;
        }
    }

    /**
     * @param $route
     * @param null $message
     * @return RedirectResponse
     */
    private function catchException($route, $message=null){
        /*if($message !== null){
            $this->mfs->messageError($message);
        }*/
        return new RedirectResponse($this->_router->generate($route));
    }
}