<?php


namespace App\Repository;


use App\Entity\CallRequest;
use App\Exception\PersistCallRequestException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;

class CallRequestRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CallRequest::class);
    }


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