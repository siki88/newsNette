<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 16.1.2019
 * Time: 11:12
 */

// PO KONEČNÉM UPGRADE NA DOCTRINE SMAZAT

namespace App\Model;

use Nette,
     Nette\Database\Context,
     Nette\Utils\DateTime,
     Nette\Utils\Validators,
     Nette\Utils\Random;

use App\Model\Facades\TokenFacade;
//use Doctrine\ORM\Mapping as ORM;

class TokenManager  {

    use Nette\SmartObject;

    //old
    private $database,
             $usersManager;

    private $tokenFacade;

    public function __construct(Context $database, UsersManager $usersManager, TokenFacade $tokenFacade){
        $this->database = $database;
        $this->usersManager = $usersManager;

        $this->tokenFacade = $tokenFacade;
    }

    private function getToken(){
        return $this->database->table('tokens');
    }


    /*vyhledá zda má uživatel token,
    *     pokud nemá -> založí nový,
    *     pokud má -> updatuje expirační datum datum, a to :
    *                pokud je expirační datum menší než aktuální -> pouze prodlouží expirační datum
    *                pokud je expirační datum větší než aktuální -> vygeneruje nový token a prodlouží expirační datum
    */
    public function setTokenUserId(int $user_id){
        //controll exists old token
//upgrade to doctrine - OK
        $parametersToken = array('user_id' => $user_id);
        $controll = $this->tokenFacade->getTokenOneParam($parametersToken);
        if($controll){ // exists user token -> update
            //pokud existuje token pro user_id, ale expirace je stará - vygenerujeme nový token
            $status = 'update';
            //kontrola expirace
            if(DateTime::from('0')->format('Y-m-d H:m:s') > $controll->expirated_at->format('Y-m-d H:m:s')){
                $status = 'insert';
            }
            //prodloužení expirace
             $this->expirateExtended($controll->id, $user_id, $status);

            //vytáhnutí údajů tokenu
            return $this->tokenFacade->getTokenId($controll->id);
        }else{ // none exists token -> insert

//upgrade to doctrine - CEKA
            $tokenTable = $this->getToken()->insert($this->generateTableToken($user_id,'insert'));
            return $this->tokenFacade->getTokenId($tokenTable->id);

        }
    }


    //vyhledá zda existuje token, pokud ano, prodlouží expiraci, pokud ne vyhodí false - používá se v ApiPresenteru
    public function getControlExpiration($token){
        $tokenTable = $this->setTokenToken($token);
        if($tokenTable && Validators::isNumericInt($tokenTable->id)){
            $this->expirateExtended($tokenTable->id, $tokenTable->user_id,'update');
            return $tokenTable;
        }else{
            return false;
        }
    }

//upgrade to doctrine - OK
    public function setTokenToken($token){
        $parametersToken = array('token' => $token);
        return $this->tokenFacade->getTokenOneParam($parametersToken);
        //  return $this->getToken()->where('token', $token)->fetch();
    }

//upgrade to doctrine - OK
    // prodloužení platnosti, a za určitých podmínek změna tokenu
    private function expirateExtended($id,$user_id, $status){
        $parametersTokenQuery = array('id' => $id);
        $this->tokenFacade->setToken($this->generateTableToken($user_id, $status),$parametersTokenQuery);
    }


    private function generateTableToken($user_id, $status){
        
        $createTokenTable = [
            'updated_at' => DateTime::from(0),
            'expirated_at' => DateTime::from(21600)
        ];

        if($status === 'insert'){
            $createTokenTable['user_id']  = $user_id;
            $myToken = Random::generate(88, '0–9a-zA-Z');
            $createTokenTable['token'] = $myToken;
        }

        return($createTokenTable);
    }


}