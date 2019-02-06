<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 4.2.2019
 * Time: 12:46
 */

namespace App\Model\Facades;

use App\Model\Entities\User;
use App\Model\Entities\Roles;
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

    public function getAllUsers(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function getKeyUsers(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function getUserId(int $id){
        return isset($id) ? $this->entityManager->find($this->entityName, $id) : NULL;
    }

    //nepoužívá se / nefunkční
    public function getPublicUsersRole(){
        $usersRole = $this->entityManager->createQueryBuilder();
        $usersRole->select('u.* , r.name')
                  ->from('App\Model\Entities\User', 'u')
                  ->leftJoin('App\Model\Entities\Roles','r','u.roles_id = r.id');
        return $usersRole->getQuery()->getResult();
    }



}