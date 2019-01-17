<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 16.1.2019
 * Time: 11:12
 */

namespace App\Model;

use Nette;
use Nette\Database\Context;

class NewsManager {

    use Nette\SmartObject;

    private $database;

    public function __construct(Context $database){
        $this->database = $database;
    }

    public function getPublicNews(){
        return $this->database->table('news');
    }

    public function getPublicNewsWithInch(){
        return $this->database->query('SELECT news.*, SUM(evaluation.inch_up) AS inch_up , SUM(evaluation.inch_down) AS inch_down FROM news LEFT JOIN evaluation ON news.id = evaluation.news_id GROUP BY news.id');

    }

    public function getNameColumns(){
        return $this->database->getConnection()->GetSupplementalDriver();
    }

    public function setAddNews($values){
        $this->database->table('news')->insert($values);
    }


}