<?php


namespace App\Service;


use App\Entity\CallRequest;
use App\Exception\CallRequestSessionException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SessionService
{
    protected $session;
    protected $translator;

    const CALL_REQUEST = "callrequest";

    /**
     * SessionService constructor.
     * @param SessionInterface $session
     * @param TranslatorInterface $translator
     */
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
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

            throw new CallRequestSessionException($this->translator->trans('ex.session.error'));
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