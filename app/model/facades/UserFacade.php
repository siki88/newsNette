<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 4.2.2019
 * Time: 12:46
 */

namespace App\Model\Facades;

use App\Model\Entities\User;
//use App\Model\Entities\Roles;
use Kdyby\Doctrine\EntityManager;

class UserFacade{

    /**
     *@inject
     *@var \Kdyby\Doctrine\EntityManager
     */
    public $entityManager;
    private $entityName = User::class;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getUsersAll(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function getUsersCount(array $parameters = []){
        return $this->entityManager->getRepository($this->entityName)->count($parameters);
    }

    public function getUserId(int $id){
        return isset($id) ? $this->entityManager->find($this->entityName, $id) : NULL;
    }

    public function getUsersFindPairs($value){
        return isset($value) ? $this->entityManager->getRepository($this->entityName)->findPairs($value) : NULL;
    }

    public function getUsersParam(array $parameters = []){
        return isset($parameters) ? $this->entityManager->getRepository($this->entityName)->findBy($parameters) : NULL;
    }

    public function getUsersOneParam(array $parameters = []){
        return isset($parameters) ? $this->entityManager->getRepository($this->entityName)->findOneBy($parameters) : NULL;
    }

    public function getUsersAllJoinAll(){
        $query = $this->entityManager->createQuery("SELECT u, r.name FROM App\Model\Entities\User u JOIN App\Model\Entities\Roles r WHERE u.roles_id = r.id");
        return isset($query) ? $query->getResult() : NULL;
    }




}