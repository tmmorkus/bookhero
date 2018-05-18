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
        return new Identity($user->id, $user->role, ['email' => $user->email]);
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
