<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 4.2.2019
 * Time: 12:46
 */

namespace App\Model\Facades;

use App\Model\Entities\Roles;
use Kdyby\Doctrine\EntityManager;

class RolesFacade{

    /**
     *@inject
     *@var \Kdyby\Doctrine\EntityManager
     */
    public $entityManager;
    private $entityName = Roles::class;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getRolesAll(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function getRolesCount(array $parameters = []){
        return $this->entityManager->getRepository($this->entityName)->count($parameters);
    }

    public function getRolesId(int $id){
        return isset($id) ? $this->entityManager->find($this->entityName, $id) : NULL;
    }

    public function getRolesFindPairs($value){
        return $this->entityManager->getRepository($this->entityName)->findPairs($value);
    }




}