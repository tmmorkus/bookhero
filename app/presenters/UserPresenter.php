<?php

namespace App\Presenters;

use App\Model\Entities\User;
use App\Model\UsersModel;
use Czubehead\BootstrapForms\BootstrapForm;
use Kdyby\Facebook\Facebook;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\Paginator;

/**
 * Class UserPresenter
 * @package Blog\Presenters
 */
class UserPresenter extends BasePresenter
{
    /** @var  UsersModel $usersModel */
    private $usersModel;

    private $facebook;

    public function actionLogout()
    {
        if ($this->user->isLoggedIn()) {
            $this->flashMessage('Byli jste úspěšně odhlášeni.');
            $this->user->logout(true);
        }
        $this->redirect('Book:list');
    }

    public function createComponentChangePasswordForm()
    {

        $form = new BootstrapForm;
        if (!empty($this->user->getIdentity()->password)) {
            $form->addPassword('OldPassword', 'Původní heslo:')
                ->setRequired('Je nutné zadat aktuální heslo.')
                ->addRule(Form::MIN_LENGTH, 'Heslo musí mít minumálně 6 znaků.', 6)
                ->addRule(function (TextInput $input) {
                    return (password_verify($input->value, $this->user->getIdentity()->password));
                }, 'Špatně zadané staré heslo');
        }
        $password = $form->addPassword('password', 'Heslo:')
            ->setRequired('Je nutné zadat heslo.')
            ->addRule(Form::MIN_LENGTH, 'Heslo musí mít minumálně 6 znaků.', 6);
        $form->addPassword('password2', 'Potvrzení hesla:')
            ->addRule(Form::EQUAL, 'Zadaná hesla se neshodují.', $password)
            ->setRequired('Je nutné ověřit heslo');
        $form->addSubmit('ok', 'Změnit heslo');

        $form->onSuccess[] = [$this, 'changePasswordSucceeded'];
        return $form;
    }

    public function changePasswordSucceeded($form, $values)
    {
        $this->user->getIdentity()->password = User::encodePassword($values->password);

        if ($this->usersModel->changePassword($this->user->id, $this->user->getIdentity()->password)) {
            $this->flashMessage('Heslo změněno');
        }
        $this->redirect('this');
    }

    /**
     * Formulář pro přihlášení uživatele
     * @return Form
     */
    public function createComponentLoginForm()
    {
        $form = new BootstrapForm;
        $form->addText('email', 'E-mail')
            ->setRequired('Je nutné zadat e-mail.')
            ->addRule(Form::EMAIL, 'Je nutné zadat platnou e-mailovou adresu.');
        $form->addPassword('password', 'Heslo:')
            ->setRequired('Je nutné zadat heslo.');
        $form->addSubmit('ok', 'přihlásit se');
        $form->onSuccess[] = [$this, 'loginSucceeded'];
        return $form;
    }

    public function loginSucceeded($form, $values)
    {
        //$user = $this->usersModel->findByEmail($values->email);
        try {

            $this->getUser()->login($values->email, $values->password);
        } catch (\Exception $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
        if ($this->user->isLoggedIn()) {

            $this->redirect('Book:list');
        }
    }

    public function handleAdmin($id)
    {
        if ($this->user->isInRole('admin') == 1) {
            $userRole = $this->usersModel->findUserRole($id);
            $role     = "";
            if ($userRole == "admin") {
                $role = "registered";
            } else {
                $role = "admin";
            }
            $this->usersModel->updateRoles($id, $role);
            $this->flashMessage('Práva uživateli změněna');
        }

    }

    public function handleDelete($id)
    {
  

        if ($this->user->isInRole('admin') == 1) {
            if ($this->usersModel->deleteUser($id)) {
                $this->flashMessage('Uživatel by smazán.');
            }
        }
    }
    
    public function renderRegister()
    {
      if($this->user->isLoggedIn())
      {
        $this->flashMessage('Nelze se registrovat jestliže jste přihlášen');
        $this->redirect('Book:list');
      }
    }
      public function renderLogin()
    {
      if($this->user->isLoggedIn())
      {
        $this->flashMessage('Nelze se znovu přihlásit.');
        $this->redirect('Book:list');
      }
    }

    public function renderList($order, $orderBy, $page, $orderPrev)
    {
      if ($this->user->isInRole('admin') == 1)
      {
        $usersCount = $this->usersModel->findUsersCount();

        if ($page == 2 && $order == "asc") {
            $order = "desc";
        }
        elseif ($page == 2  && $order == "desc")
        {
            $order = "asc";
        }

        $paginator = new Paginator();
        $paginator->setItemCount($usersCount);
        $paginator->setItemsPerPage(10);
        $paginator->setPage($page);

        $this->template->users = $this->usersModel->findUsers($orderBy, $order, $paginator->getLength(), $paginator->getOffset());
        if ($page == 1)
        {
          if ($order == "desc") {
            $order = "asc";
          } else {
            $order = "desc";
           } 
        }


        $this->template->paginator = $paginator;
        $this->template->orderPrev = $orderBy;
        $this->template->order     = $order;
       }
    }

    /**
     * Formulář pro registraci uživatele
     * @return Form
     */
    public function createComponentRegistrationForm()
    {

        $form = new BootstrapForm;
        $form->addText('email', 'E-mail:')
            ->setRequired('Je nutné zadat e-mail')
            ->addRule(Form::EMAIL, 'Je nutné zadat platnou e-mailovou adresu.')
            ->addRule(function (TextInput $input) {
                return !($this->usersModel->findByEmail($input->value));
            }, 'Uživatel s daným e-mailem již existuje.');
        $password = $form->addPassword('password', 'Heslo:')
            ->setRequired('Je nutné zadat heslo.')
            ->addRule(Form::MIN_LENGTH, 'Heslo musí mít minumálně 6 znaků.', 6);
        $form->addPassword('password2', 'Potvrzení hesla:')
            ->addRule(Form::EQUAL, 'Zadaná hesla se neshodují.', $password)
            ->setRequired('Je nutné ověřit heslo');
        $form->addSubmit('ok', 'registrovat se');
        $form->onSuccess[] = [$this, 'registrationSucceeded'];
        return $form;
    }

    public function createComponentFbLogin()
    {

        $dialog               = $this->facebook->createDialog('login');
        $dialog->onResponse[] = function (\Kdyby\Facebook\Dialog\LoginDialog $dialog) {
            $fb = $dialog->getFacebook();
            if (!$fb->getUser()) {
                $this->flashMessage("Přihlášení pomocí faccebooku selhalo");
                return;
            }

            $me = $fb->api('/me', null, ['fields' => ['id', 'email']]);

            $existing = $this->usersModel->findByFacebookId($me->id, $me->email);
            if (empty($existing)) {
                $existing = $this->usersModel->registerFromFacebook($me->id, $me->email);
            }

            $this->user->login(new \Nette\Security\Identity($existing->id, $existing->role, $existing));

            $this->redirect('Book:list');
        };

        return $dialog;
    }

    public function registrationSucceeded($form, $values)
    {
        //funkce pro vytvoření nového uživatelského účtu a automatick přihlášení uživatele

        $user           = new User();
        $user->active   = true;
        $user->email    = $values->email;
        $user->password = User::encodePassword($values->password);
        $user->role     = User::DEFAULT_REGISTERED_ROLE;
        if ($this->usersModel->save($user)) {
            $this->flashMessage('Registrace byla úspěšně dokončena.');
            $this->user->login($values->email, $values->password);
            $this->redirect('Book:list');
        }

        return $form;
    }

    #region injections
    public function injectUsersModel(UsersModel $usersModel)
    {
        $this->usersModel = $usersModel;
    }

    public function injectFacebook(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }
    #endregion injections
}
