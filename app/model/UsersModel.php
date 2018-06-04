<?php

namespace App\Model;

use App\Model\Entities\Article;
use App\Model\Entities\User;
use Nette\Security\AuthenticationException;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use \PDO;

/**
 * Class UsersModel - třída pro práci s uživateli
 * @package Blog\Model
 */
class UsersModel implements \Nette\Security\IAuthenticator
{
    /** @var PDO $pdo */
    private $pdo;

    /**
     * Funkce pro nalezení všech uživatelů
     * @return User[]
     */
    public function findAll()
    {
        $query = $this->pdo->prepare('SELECT * FROM users');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\Entities\User');
    }

    /**
     * Funkce pro nalezení jednoho uživatele podle ID
     * @param int $id
     * @return User
     */
    public function findById($id)
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE id=:id LIMIT 1;');
        $query->execute([':id' => $id]);
        return $query->fetchObject(__NAMESPACE__ . '\Entities\User');
    }

    public function changePassword($userId,$password)
    {
       $sql = 'UPDATE users SET password = ? where id =?';
       $query = $this->pdo->prepare($sql); 
       $result = $query->execute([$password,$userId]);
       return  $result;
    }

    public function findUserRole($id)
    {
      $sql = 'SELECT role from users where id =?';
       $query = $this->pdo->prepare($sql); 
       $query->execute([$id]);

       return $query->fetchColumn();
    }
    public function findUsersCount()
    {
       $sql = 'SELECT COUNT(*) from users';
       $query = $this->pdo->prepare($sql); 
       $query->execute();

       return $query->fetchColumn();
    }

    public function deleteUser ($id)
    {
       
       $sql = 'DELETE FROM user_books where userId =?';
       $query = $this->pdo->prepare($sql); 
       $result = $query->execute([$id]);


      $sql = 'DELETE FROM users where id =?';
       $query = $this->pdo->prepare($sql); 
       $result = $query->execute([$id]);
       return  $result;
    }
    
    public function findByFacebookId ($fbId,$email)
    {
       $sql = 'SELECT * from users where fbId = ? or email=?';
       $query = $this->pdo->prepare($sql); 
       $query->execute([$fbId, $email]);

       return $query->fetchObject(__NAMESPACE__ . '\Entities\User');
    }

    public function updateRoles($id, $role) 
    {

      $sql = 'UPDATE users set role = ? where id = ?';
      $query = $this->pdo->prepare($sql); 
      $result = $query->execute([$role,$id]);
      return $result; 

    }

    public function registerFromFacebook($id,$email)
    {
        $sql     = 'INSERT INTO users (email,fbId,role) VALUES (?,?,?)';
        $query   = $this->pdo->prepare($sql);
        $result = $query->execute([$email,$id,"registered"]);
        $dbId = $this->pdo->lastInsertId();
 
        return $this->findById($dbId);
    }

    public function findUsers($orderBy, $order, $limit,$offset)
    {
        $sql = 'SELECT * FROM users '; 
       if (!(in_array($orderBy, ["id", "email","role"]) && in_array($order, ["asc", "desc"]))) {
           $orderBy = 'id';
           $order =  'asc'; 
        }
         $sql .= 'GROUP BY users.id '; 
         $sql .= 'ORDER BY ' . $orderBy . " " . $order;
         $sql .= ' LIMIT :limit OFFSET :offset';


        $query = $this->pdo->prepare($sql);
        $query->bindParam(':offset',$offset,PDO::PARAM_INT);
        $query->bindParam(':limit',$limit,PDO::PARAM_INT);
   
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\Entities\Book');

    }

    /**
     * Funkce pro nalezení uživatele podle e-mailu
     * @param string $email
     * @return User
     */
    public function findByEmail($email)
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE email=:email LIMIT 1;');
        $query->execute([':email' => $email]);
        return $query->fetchObject(__NAMESPACE__ . '\Entities\User');
    }

    /**
     * Funkce pro smazání jednoho článku
     * @param User|int $id
     * @return bool
     */
    public function delete($id)
    {
        if ($id instanceof User) {
            $id = $id->id;
        }
        $query = $this->pdo->prepare('DELETE FROM users WHERE id=:id LIMIT 1;');
        return $query->execute([':id' => $id]);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user)
    {

        $sql     = 'INSERT INTO users (email,password,role) VALUES (?,?,?)';
        $query   = $this->pdo->prepare($sql);
        $result = $query->execute([$user->email,$user->password,$user->role]);

        return $result;
    }

    /**
     * Funkce pro autentizaci uživatele (využívá metod frameworku)
     * @param array $credentials
     * @return IIdentity
     * @throws AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials; //TODO pamatujete si tuhle konstrukci?
        $user                      = $this->findByEmail($username);
        if (!$user) {
            throw new AuthenticationException('Uživatelský účet nenalezen.', self::IDENTITY_NOT_FOUND);
        }
        if (!$user->isValidPassword($password)) {
            throw new AuthenticationException('Chybné heslo.', self::INVALID_CREDENTIAL);
        }
        return new Identity($user->id, $user->role, ['email' => $user->email, 'password' => $user->password]);
    }

    /**
     * ArticlesModel constructor
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

}
