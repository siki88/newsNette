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

class EvaluationsManager {

    use Nette\SmartObject;

    private $database;

    public function __construct(Context $database){
        $this->database = $database;
    }

    public function getPublicEvaluationNewsId($newsId){
        return $this->database->table('evaluation')->where('news_id', $newsId);
    }

    public function getNameColumns(){
        return $this->database->getConnection()->GetSupplementalDriver();
    }

    public function getPublicEvaluationInchNewsId($newsId){
        var_dump($newsId);
    }

    public function setPublicEvaluationDelete($evId){
        return $this->database->table('evaluation')->where('id', $evId)->delete();
    }


}