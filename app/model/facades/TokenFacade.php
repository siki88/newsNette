<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 4.2.2019
 * Time: 12:46
 */

namespace App\Model\Facades;

use App\Model\Entities\Token;
use Kdyby\Doctrine\EntityManager;

class TokenFacade{

    /**
     *@inject
     *@var \Kdyby\Doctrine\EntityManager
     */
    public $entityManager;
    private $entityName = Token::class;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getTokenAll(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function getTokenId(int $id){
        return isset($id) ? $this->entityManager->find($this->entityName, $id) : NULL;
    }

    public function getTokenParam(array $parameters = []){
        return isset($parameters) ? $this->entityManager->getRepository($this->entityName)->findBy($parameters) : NULL;
    }

    public function getTokenOneParam(array $parameters = []){
        return isset($parameters) ? $this->entityManager->getRepository($this->entityName)->findOneBy($parameters) : NULL;
    }

    public function setToken($parametersData, array $parametersQuery = []){
        if(count($parametersQuery) >= 1){ //UPDATED
            $value = $this->getTokenOneParam($parametersQuery);
            $value->updated_at = $parametersData['updated_at'];
            $value->expirated_at = $parametersData['expirated_at'];
        }else{ //INSERT
            $this->entityManager->persist((object)$parametersData);
        }
        $this->entityManager->flush();
    }




}