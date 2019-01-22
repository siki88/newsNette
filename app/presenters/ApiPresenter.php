<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use Nette;
use Nette\Utils\Json;
use Nette\Application\IResponse;
use App\Model\NewsManager;
use App\Model\AuthenticatorManager;
    use App\Model\UsersManager;
    use App\Model\EvaluationsManager;
use App\Model\TokenManager;
//use Nette\Http\Request;
//use Nette\Http\UrlScript;
//use Nette\Security\IAuthenticator;
use Nette\Utils\Validators;

use Nette\Application\Responses\JsonResponse;

final class ApiPresenter extends Presenter{

    private $newsManager;
    private $usersManager;
    private $evaluationsManager;
    private $authenticatorManager;
    private $tokenManager;

    public function __construct(NewsManager $newsManager, UsersManager $usersManager, EvaluationsManager $evaluationsManager, AuthenticatorManager $authenticatorManager, TokenManager $tokenManager){
        $this->newsManager = $newsManager;
        $this->usersManager = $usersManager;
        $this->evaluationsManager = $evaluationsManager;
        $this->authenticatorManager = $authenticatorManager;
        $this->tokenManager = $tokenManager;
    }


    public function renderDefault(){
    }

    /**
     * @throws Nette\Application\AbortException
     */
    public function actionDefault(){
    }


    public function actionLogin(){
        //whitelist
        $securityArray = ['email','password'];
        $httpRequest = $this->getHttpRequest();
            if($httpRequest->isMethod('POST')){
                $request = array_intersect_key($httpRequest->getPost(), array_flip($securityArray));
                    if(Validators::isEmail($request['email'])){
                        $status = $this->authenticatorManager->authenticate($request)->getData();
                    }else{
                        $status = [
                            'code' => 406,
                            'description' => 'Invalid email format'
                        ];
                    }

                $this->response($status);
            }
    }

    public function actionToken(){
        //whitelist
        $securityArray = ['token'];
        $httpRequest = $this->getHttpRequest();
        if($httpRequest->isMethod('POST')){
            $request = array_intersect_key($httpRequest->getPost(), array_flip($securityArray));

            // KONTROLA EXPIRACE TOKENU
            $status = $this->tokenManager->getControlExpiration($request['token']);

            if($status){
                $status = [
                    'code' => 200,
                    'description' => 'Token is ok. Expirate date is extended'
                ];
            }else{
                $status = [
                    'code' => 401,
                    'description' => 'Token has expired, login in again. OR not found'
                ];
            }
            $this->response($status);
        }
    }



    public function actionNews(){
        $data = $this->newsManager->getPublicNewsQuery();
        $this->response($data);

    }

    //zaslání hodnocení
    public function actionEvaluation(){
        //whitelist
        $securityArray = ['token','news_id','evaluation'];
        $httpRequest = $this->getHttpRequest();

        //$this->controllValidation($httpRequest->getPost(), $securityArray);

        if($httpRequest->isMethod('POST')){
            $request = array_intersect_key($httpRequest->getPost(), array_flip($securityArray));
                if($request && !Validators::isList($request) && Validators::isNumericInt($request['news_id']) && !Validators::isNone($request['token'])){
                    $tokenTable = $this->tokenManager->getControlExpiration($request['token']);
                    if($tokenTable){
                        //if exists news_id
                        if($this->newsManager->getPublicNewsId($request['news_id'])){
                            if($this->evaluationsManager->setPublicEvaluation($request['news_id'],$request['evaluation'],$tokenTable->user_id)){
                                $status = [
                                    'token' => $tokenTable->token,
                                    'code' => 200,
                                    'description' => 'evaluation is save'
                                ];
                            }else{
                                $status = [
                                    'code' => 409,
                                    'description' => 'evaluation is unsaved'
                                ];
                            }
                        }else{
                            $status = [
                                'code' => 401,
                                'description' => 'News not found'
                            ];
                        }
                    }else{
                        $status = [
                            'code' => 401,
                            'description' => 'Token has expired, login in again. OR not found'
                        ];
                    }
                }else{
                    $status = [
                        'code' => 409,
                        'description' => 'Invalid parameters'
                    ];
                }
            $this->response($status);
        }
    }


    /*
    private function controllValidation($httpRequest,$securityArray){
        //whitelist
        $securityArray = [
                        'token'    => 'string',
                        'evaluation_id' => 'string',
                        'evaluation' => 'string'
                         ];

        foreach($securityArray as $key => $value){

            if(Validators::assertField($httpRequest, 'token', 'string')){
                var_dump('yes');
                die();
            }else{
                $status = [ 'code' => 409, 'description' => 'Invalid parameterss' ];
                $this->response($status);
            }
            return true;
        }

    }
    */

    private function response($data){
        $this->sendResponse(new JsonResponse($data, "application/json;charset=utf-8"));
    }


}
