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
use Nette\Security\Passwords;

class UsersManager {

    use Nette\SmartObject;

    private $database;

    public function __construct(Context $database){
        $this->database = $database;
    }

    public function getPublicUsers(){
        return $this->database->table('users');
    }

    public function getNameColumns(){
        return $this->database->getConnection()->GetSupplementalDriver();
    }

    public function setAddUser($values){
        $values->password = Passwords::hash($values->password);
        $this->database->table('users')->insert($values);
    }
}