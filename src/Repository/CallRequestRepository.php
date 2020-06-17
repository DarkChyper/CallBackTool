<?php


namespace App\Repository;


use App\Entity\CallRequest;
use App\Exception\PersistCallRequestException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class CallRequestRepository extends EntityRepository
{


    public function saveCallRequest(CallRequest $callRequest)
    {
        try {
            $this->getEntityManager()->persist($callRequest);
            $this->getEntityManager()->flush();
        } catch (ORMException $e) {
            throw new PersistCallRequestException($e);
        }

    }

    /**
     * @return mixed
     */
    public function getAllCallRequest()
    {
        return $this->findAll();
    }
}