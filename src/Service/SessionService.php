<?php


namespace App\Service;


use App\Entity\CallRequest;
use App\Exception\CallRequestSessionException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionService
{
    protected $session;

    const CALL_REQUEST = "callrequest";

    /**
     * SessionService constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * get or create CallRequest in session
     * @return CallRequest
     */
    public function getOrCreateCallRequestSession(){
        if( ! $this->session->has(self::CALL_REQUEST) ||
            $this->session->get(self::CALL_REQUEST) === null){

            $this->saveCallRequestSession(new CallRequest());
        }
        return $this->session->get(self::CALL_REQUEST);
    }

    public function getCallRequestSession(){
        if(! $this->session->has(self::CALL_REQUEST) ||
            $this->session->get(self::CALL_REQUEST) === null ||
            $this->session->get(self::CALL_REQUEST)->getNational() === null){

            throw new CallRequestSessionException("No valid call request in session");
        }
        return $this->session->get(self::CALL_REQUEST);
    }

    /**
     * @param CallRequest $callrequest
     */
    public function saveCallRequestSession(CallRequest $callrequest){
        $this->session->set(self::CALL_REQUEST, $callrequest);
    }

    /**
     * remove CallRequest from session
     */
    public function deleteCallRequestInSession(){
        $this->session->remove(self::CALL_REQUEST);
    }


}