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

class RolesManager {

    use Nette\SmartObject;

    private $database;

    public function __construct(Context $database){
        $this->database = $database;
    }

    private function getTableRoles(){
        return $this->database->table('roles');
    }

    public function setRolesId($roles_id){
        return $this->getTableRoles()->get($roles_id);
    }
}