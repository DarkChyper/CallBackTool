<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class CallRequestRepository extends EntityRepository
{

    /**
     * @return mixed
     */
    public function getAllCallRequest(){
        return $this->findAll();
    }
}