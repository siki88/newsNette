<?php

namespace App\Presenters;
//namespace App\AdminModule\Presenters;

use Nette\Application\UI\Presenter,
     Nette\Application\UI\Form,
     Nette\Security\AuthenticationException,
     App\Model\NewsManager,
     App\Model\UsersManager,
     App\Model\EvaluationsManager,
     App\Model\RolesManager;
use App\Presenters\BasePresenter;

final class AdminPresenter extends BasePresenter{

    private $newsManager,
             $usersManager,
             $evaluationsManager,
             $rolesManager;

    public function __construct(NewsManager $newsManager, UsersManager $usersManager, EvaluationsManager $evaluationsManager, RolesManager $rolesManager){
        $this->newsManager = $newsManager;
        $this->usersManager = $usersManager;
        $this->evaluationsManager = $evaluationsManager;
        $this->rolesManager = $rolesManager;
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
        $this->template->newsValues = $this->newsFacade->getNewsAll();
     //   $this->template->newsKeys = $this->newsManager->getNameColumns()->getColumns('news');
    //    $this->template->newsValues = $this->newsManager->getPublicNewsWithInch();
      //  $this->template->newsValues = $this->newsFacade->getPublicNewsWithInch();
    }

    public function actionNews(){
    }

//update doctrine - OK
    public function renderUsers(){
        $this->template->usersValues = $this->userFacade->getUsersAll();
    }

    public function actionUsers(){
    }

//update doctrine - OK
    public function renderEvaluations($newsId){
        $parametersEvaluation = array('news_id' => $newsId);
        $this->template->evaluationsValues = $this->evaluationFacade->getEvaluationParam($parametersEvaluation);
        $this->template->titleNews = $this->newsFacade->getNewsId($newsId)->shortText;
    }

    public function actionEvaluations($newsId){
    }

    public function actionLogin(){
    }

    private function controlUserLogin(){
            //pokud je přihlášený a pokud má roli administrátora
        if($this->getUser()->isLoggedIn() && in_array("admin", $this->user->getIdentity()->getRoles())){
            $this->user->setExpiration('15 minutes');
        }elseif($this->getAction() !== 'login'){
            $this->redirect('Admin:login');
        }
    }

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
                $form->addSelect('users_id', 'Autor novinky:', $this->usersManager->getPublicUsers()->fetchPairs('id', 'username'));
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
                $form->addSelect('roles_id', 'Oprávnění:', $this->rolesManager->getPublicRoles()->fetchPairs('id', 'name'));
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
