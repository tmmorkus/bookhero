<?php

namespace App\Presenters;

use App\Model\Entities\User;
use App\Model\UsersModel;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\SubmitButton;
use Nette\Forms\Controls\TextInput;

/**
 * Class UserPresenter
 * @package Blog\Presenters
 */
class UserPresenter extends BasePresenter{
  /** @var  UsersModel $usersModel */
  private $usersModel;

  /**
   * Akce pro přihlášení uživatele
   */
  public function actionLogin(){
    if ($this->user->isLoggedIn()){
      $this->redirect('Homepage:default');
      return;
    }
  }

  /**
   * Akce pro odhlášení uživatele
   */
  public function actionLogout(){
    if ($this->user->isLoggedIn()){
      $this->flashMessage('Byli jste úspěšně odhlášeni.');
      $this->user->logout(true);
    }
    $this->redirect('Homepage:default');
  }

  /**
   * Akce pro registraci uživatele
   */
  public function actionRegister(){
    if ($this->user->isLoggedIn()){
      $this->flashMessage('Nelze registrovat nový účet, když jste přihlášeni.');
      $this->redirect('Homepage:default');
    }
  }

   /**
   * Formulář pro přihlášení uživatele
   * @return Form
   */
  public function createComponentLoginForm(){
    $form = new Form();
    $form->addText('email','E-mail')
      ->setRequired('Je nutné zadat e-mail.')
      ->addRule(Form::EMAIL,'Je nutné zadat platnou e-mailovou adresu.');
    $form->addPassword('password','Heslo:')
      ->setRequired('Je nutné zadat heslo.');
    $form->addSubmit('ok','přihlásit se');
    $form->onSuccess[] = [$this, 'loginSucceeded'];   
    return $form;
  }


  public function loginSucceeded($form,$values)
  {
     //$user = $this->usersModel->findByEmail($values->email);
      try {
        $this->getUser()->login($values->email, $values->password);
      } catch (\Exception $e) {
        $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
      }
      if ($this->user->isLoggedIn()){
        $this->flashMessage($this->user->isInRole('admin'));
        $this->redirect('Homepage:default');
      }
  }

  /**
   * Formulář pro registraci uživatele
   * @return Form
   */
  public function createComponentRegistrationForm(){
    $form=new Form();
    $form->addText('email','E-mail:')
      ->setRequired('Je nutné zadat e-mail')
      ->addRule(Form::EMAIL,'Je nutné zadat platnou e-mailovou adresu.')
      ->addRule(function(TextInput $input){
        return !($this->usersModel->findByEmail($input->value));
      },'Uživatel s daným e-mailem již existuje.');
    $password=$form->addPassword('password','Heslo:')
      ->setRequired('Je nutné zadat heslo.')
      ->addRule(Form::MIN_LENGTH,'Heslo musí mít minumálně 6 znaků.',6);
    $form->addPassword('password2','Potvrzení hesla:')
      ->addRule(Form::EQUAL,'Zadaná hesla se neshodují.',$password)
      ->setRequired('Je nutné ověřit heslo');
    $form->addSubmit('ok','registrovat se');
    $form->onSuccess[] = [$this, 'registrationSucceeded'];   
    return $form; 
  }

  public function registrationSucceeded($form,$values)
  {
      //funkce pro vytvoření nového uživatelského účtu a automatick přihlášení uživatele
  
      $user=new User();
      $user->active=true;
      $user->email=$values->email;
      $user->password=User::encodePassword($values->password);
      $user->role=User::DEFAULT_REGISTERED_ROLE;
      if ($this->usersModel->save($user)){
        $this->flashMessage('Registrace byla úspěšně dokončena.');
       $this->user->login($values->email,$values->password);
       $this->redirect('Homepage:default');
      }

      return $form;
  }


  #region injections
  public function injectUsersModel(UsersModel $usersModel){
    $this->usersModel=$usersModel;
  }
  #endregion injections
}