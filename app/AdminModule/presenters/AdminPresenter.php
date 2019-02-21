<?php

namespace App\Presenters;
//namespace App\AdminModule\Presenters;

use Nette\Application\UI\Presenter,
     Nette\Application\UI\Form,
     Nette\Security\AuthenticationException,
     App\Model\NewsManager,
     App\Model\UsersManager;
use App\Presenters\BasePresenter;

use Kdyby\DoctrineForms\EntityForm;

use Nette\Utils\DateTime,
     Nette\Utils\Random;

final class AdminPresenter extends BasePresenter{

    private $newsManager;
    private $usersManager;

    public function __construct(NewsManager $newsManager, UsersManager $usersManager){
        $this->newsManager = $newsManager;
        $this->usersManager = $usersManager;
    }


    /**
     * Volá se na začátku každé akce, každého presenteru a zajišťuje inicializaci entity uživatele.
     */
    public function startup(){
        parent::startup();
        $this->controlUserLogin();
    }

    /**
     * Volá se před vykreslením každého presenteru a předává společné proměnné do celkového layoutu webu.
     */
    public function beforeRender(){
        parent::beforeRender();
    }

//update doctrine - OK
    public function renderDefault(){
        $this->template->usersCount = $this->userFacade->getUsersCount();
        $this->template->newsCount = $this->newsFacade->getNewsCount();
        //metody user
        $this->template->role = $this->user->getIdentity()->getRoles()[0];
        $this->template->email = $this->user->getIdentity()->email;
    }

    public function actionDefault(){

    }

//update doctrine - chybí inch_up + inch_down
    public function renderNews(){
        $newsAll = $this->newsFacade->getNewsAll();

        foreach($newsAll as $key => $value){
            $newsAll[$key]->users_id = $this->userFacade->getUserId($value->users_id);
        }

        $this->template->newsValues = $newsAll;
    }

    public function actionNews(){
        /*
            //MY TEST SAVE ON MEMORY
            $cacheDriver = new \Doctrine\Common\Cache\ArrayCache();

            $myData = ['hello',
                    'world',
                    DateTime::from(0),
                    Random::generate(88, '0–9a-zA-Z')
                      ];

            $cacheDriver->save(5,$myData,false);

            //MY TEST LOAD ON MEMORY
            if($cacheDriver->contains(5)){
                echo('cache exists');
                dump($cacheDriver->fetch(5));
            }else{
                echo('cache does not exists');
            }

            //MY TEST DELETE MEMORY
            //$cacheDriver->delete(5);
            $cacheDriver->deleteAll();
        */
    }

//update doctrine - OK
    public function renderUsers(){
        $usersAll = $this->userFacade->getUsersAll();

        foreach($usersAll as $key => $value){
            $usersAll[$key]->roles_id = $this->rolesFacade->getRolesId($value->roles_id);
        }

        $this->template->usersValues = $usersAll;
    }

    public function actionUsers(){
      //  dump($this);
    }

//update doctrine - OK
    public function renderEvaluations($newsId){
        $parametersEvaluation = array('news_id' => $newsId);
        $evaluationAll = $this->evaluationFacade->getEvaluationParam($parametersEvaluation);

        foreach($evaluationAll as $key => $value){
            $evaluationAll[$key]->news_id = $this->newsFacade->getNewsId($value->news_id);
            $evaluationAll[$key]->users_id = $this->userFacade->getUserId($value->users_id);
        }

        $this->template->evaluationsValues = $evaluationAll;
        $this->template->titleNews = $this->newsFacade->getNewsId($newsId)->short_text;
    }

    public function actionEvaluations($newsId){
    }

    public function actionLogin(){
    }

    //metoda kontrola přihlášení a role
    private function controlUserLogin(){
            //pokud je přihlášený a pokud má roli administrátora
        if($this->getUser()->isLoggedIn() && in_array("admin", $this->user->getIdentity()->getRoles())){
            $this->user->setExpiration('480 minutes');
        }elseif($this->getAction() !== 'login'){
            $this->redirect('Admin:login');
        }
    }

    //metoda odhlášení uživatele
    public function actionOut(){
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné');
        $this->redirect('Homepage:default');
    }

//update doctrine - OK
    public function actionEvaluationsDelete(int $evaluationsId){
        $status = $this->evaluationFacade->deleteEvaluationId($evaluationsId);
        $this->flashMessage($status);
        $this->redirect('Admin:news');
    }


    protected function createComponentForm(){
        $form = new Form();

        switch ($this->getAction()) {
            case "login":
                $form->getElementPrototype()->class = 'login';
                $form->addText('username')
                    ->setRequired()
                    ->setAttribute('placeholder', 'Username')
                    ->setType('text');
                $form->addPassword('password')
                    ->setRequired()
                    ->setType('password');
                $form->addSubmit('send', 'LOGIN')
                    ->setOption('id', 'username')
                    ->setAttribute('class', 'button');
                $form->onSuccess[] = [$this, 'formSucceded'];
                break;
            case "news":
                $form->getElementPrototype()->class = 'myForm';
                $form->addText('short_text', 'Nadpis novinky:')
                    ->setRequired();
                $form->addSelect('users_id', 'Autor novinky:', $this->userFacade->getUsersFindPairs('username'));
                $form->addTextArea('text', 'Text novinky:')
                    ->setRequired();
                $form->addSubmit('send', 'Přidat novinku')
                    ->setAttribute('class', 'button');
                $form->onSuccess[] = [$this, 'formSucceded'];
                break;
            case "users":
                $form->getElementPrototype()->class = 'myForm';
                $form->addText('username', 'Uživatelské jméno')
                    ->setRequired()
                    ->setAttribute('placeholder', 'Uživatelské jméno')
                    ->setType('text');
                $form->addEmail('email', 'E-mail:')
                    ->setRequired();
                $form->addPassword('password', 'Heslo')
                    ->setRequired()
                    ->setType('password');
                $form->addSelect('roles_id', 'Oprávnění:', $this->rolesFacade->getRolesFindPairs('name'));
                $form->addSubmit('send', 'Přidat uživatele')
                    ->setAttribute('class', 'button');
                $form->onSuccess[] = [$this, 'formSucceded'];
            default:
                break;
        }
        return $form;
    }

    public function formSucceded(Form $form, \stdClass $values){

        switch ($this->getAction()) {
            case "login":
                try{
                    $this->getUser()->login($values->username,$values->password);
                    $this->redirect('default');
                }catch(AuthenticationException $e){
                    $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
                }
                break;
            case "news":

                $this->newsFacade->setNews($values);
                die();

                $this->newsManager->setAddNews($values);
                $this->flashMessage('Novinka přidána.', 'success');
                $this->redirect('news');
                break;
            case "users":
                $this->usersManager->setAddUser($values);
                $this->flashMessage('Uživatel přidán.', 'success');
                $this->redirect('users');
                break;
            default:
                break;
        }

    }
}
