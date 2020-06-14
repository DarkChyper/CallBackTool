<?php


namespace App\Service;


use App\Entity\CallRequest;

class ValidationService
{

    /**
     * ValidationService constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param CallRequest $callRequest
     * @return CallRequest
     */
    public function validateCallRequest(CallRequest $callRequest){
        $callRequest->setNational($callRequest->getPhoneNumber());
        $callRequest->setInternational($callRequest->getPhoneNumber());
        return $callRequest;
    }
}