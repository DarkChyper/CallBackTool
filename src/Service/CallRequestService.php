<?php


namespace App\Service;


use App\Entity\CallRequest;
use Doctrine\ORM\EntityManagerInterface;

class CallRequestService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * ValidationService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Validate object CallRequest
     *
     * @param CallRequest $callRequest
     * @return CallRequest
     */
    public function validateCallRequest(CallRequest $callRequest){
        $callRequest->setNational($callRequest->getPhoneNumber());
        $callRequest->setInternational($callRequest->getPhoneNumber());
        return $callRequest;
    }

    /**
     * Persist entity CallRequest
     *
     * @param CallRequest $callRequest
     */
    public function save(CallRequest $callRequest){
        $this->em->persist($callRequest);
        $this->em->flush();
    }
}