<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 4.2.2019
 * Time: 12:46
 */

namespace App\Model\Facades;

use App\Model\Entities\News;
use Kdyby\Doctrine\EntityManager;
use Nette\Utils\ArrayHash;
use Nette\Utils\Arrays;




use Nette\Application\UI\Form;
use Kdyby\DoctrineForms\EntityForm;


use Kdyby;
use Kdyby\DoctrineForms\EntityFormMapper;
use Kdyby\DoctrineForms\IComponentMapper;
use Nette;
use Nette\Application\UI;


class NewsFacade{

    /**
     *@inject
     *@var \Kdyby\Doctrine\EntityManager
     */
    public $entityManager;
    private $entityName = News::class;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getNewsAll(){
        return $this->entityManager->getRepository($this->entityName)->findAll();
    }

    public function getNewsCount(array $parameters = []){
        return $this->entityManager->getRepository($this->entityName)->count($parameters);
    }

    public function getNewsId(int $id){
        return isset($id) ? $this->entityManager->find($this->entityName, $id) : NULL;
    }

    public function getNewsParam(array $parameters = []){
        return isset($parameters) ? $this->entityManager->getRepository($this->entityName)->findBy($parameters) : NULL;
    }

    public function setNews($value){
        dump($value);
        die();
        $this->entityManager->persist($value);
        $this->entityManager->flush();
    }

    /*
    public function getPublicNewsWithInch(){
        $usersRole = $this->entityManager->createQueryBuilder();
        $usersRole->select('n , SUM(e.inch_up) AS inch_up , SUM(e.inch_down) AS inch_down')
                    ->from('App\Model\Entities\News', 'n')
                    ->leftJoin('App\Model\Entities\Evaluation','e', 'n.id = e.news_id') //'WHERE',
                    ->groupBy('n.id');
        return $usersRole->getQuery()->getResult();
       // return $this->database->query('SELECT news.*, SUM(evaluation.inch_up) AS inch_up , SUM(evaluation.inch_down) AS inch_down FROM news LEFT JOIN evaluation ON news.id = evaluation.news_id GROUP BY news.id');

    }
    */



}