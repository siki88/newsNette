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

    public function getAllNews(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function getTokenId($id){
        return isset($id) ? $this->entityManager->find($this->entityName, $id) : NULL;
    }

    public function getTokenParam($parameters){
        return isset($parameters) ? $this->entityManager->getRepository($this->entityName)->findBy($parameters) : NULL;
    }




}