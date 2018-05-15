<?php

namespace Blog\Model;

use Blog\Model\Entities\Article;
use \PDO;

/**
 * Class ArticlesModel - třída modelu pro práci s články v DB
 * @package Blog\Model
 */
class ArticlesModel
{
    /** @var PDO $pdo */
    private $pdo;

    public function findUsersBooks($userId)
    {
        $query = $this->pdo->prepare('SELECT * FROM books join user_books on books.id = user_books.bookId
        WHERE user_books.userId = ?');
        $query->execute([$userId]);
        return $query->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\Entities\Book');

    }

    public function findBooks($orderBy, $filters)
    {
        $sql = 'SELECT * FROM books ';
        if (!empty($filters)) {
            $sql += 'WHERE '; 
            foreach ($filter as $key => $value) {
                $sql += $key . ' = ' . $value . ' ';
            }
        }

        if (!empty($orderBy)) {
            $sql += 'ORDER BY ' . $orderBy
        }
        $query = $this->pdo->prepare($sql);
        $query->execute([$orderBy]);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\Entities\Book');

    }

    public function addBook($rating, $userId)
    {


    }

    
    public function rateBook()
    {
        $sql = 'UPDATE user_books SET userRating = ? WHERE userId = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute([$rating, $userId]);
        return $query->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\Entities\Book');
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
