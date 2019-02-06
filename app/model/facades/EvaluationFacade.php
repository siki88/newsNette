<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 4.2.2019
 * Time: 12:46
 */

namespace App\Model\Facades;

use App\Model\Entities\Evaluation;
use Kdyby\Doctrine\EntityManager;

class EvaluationFacade{

    /**
     *@inject
     *@var \Kdyby\Doctrine\EntityManager
     */
    public $entityManager;
    private $entityName = Evaluation::class;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getAllEvaluation(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function getEvaluationParam($parameters){
    return isset($parameters) ? $this->entityManager->getRepository($this->entityName)->findBy($parameters) : NULL;
    }





}