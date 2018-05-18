<?php

namespace App\Model;

use App\Model\Entities\Book;
use \PDO;

/**
 * Class BooksModel - třída modelu pro práci s články v DB
 * @package App\Model
 */
class BooksModel
{
    /** @var PDO $pdo */
    private $pdo;

    public function findUsersBooks($userId)
    {
        $query = $this->pdo->prepare('SELECT books.* FROM books join user_books on books.id = user_books.bookId
        WHERE user_books.userId = ?');
        $query->execute([$userId]);
        return $query->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\Entities\Book');

    }

    public function findBook($id)
    {
        $query = $this->pdo->prepare('SELECT * FROM books where id =?');
        $query->execute([$id]);
        return $query->fetchObject(__NAMESPACE__ . '\Entities\Book');
    }

    public function findBooks($orderBy, $order, $filter)
    {
        $param = [];

        $sql = 'SELECT * FROM books ';
        if (!empty($filter)) {
            $sql .= 'WHERE genreId = ? ';
            $param[] = $filter;
        }

        if (in_array($orderBy, ["name", "author", "year"]) && in_array($order, ["asc", "desc"])) {
            $sql .= 'ORDER BY ' . $orderBy . " " . $order;
        }

        $query = $this->pdo->prepare($sql);
        $query->execute($param);
        return $query->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\Entities\Book');

    }

    public function addBookToUser($bookId,$userId)
    {
        
        $sql = 'SELECT * FROM user_books WHERE bookId = ? and userId = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute([$bookId,$userId]);
        $result = $query->fetchAll();
        if (count($result) > 0) {
            return false; 
        }

        $sql = 'INSERT INTO user_books (bookId, userId) VALUES (?,?)';
        $query = $this->pdo->prepare($sql);
        $result = $query->execute([$bookId,$userId]);
        return $result; 
    }

    public function deleteBookFromUser($bookId,$userId)
    {
  
        $sql = 'DELETE FROM user_books WHERE bookId = ? and userId = ?';
        $query = $this->pdo->prepare($sql);
        $result = $query->execute([$bookId,$userId]);
        return $result; 
    }

    public function addBook(Book $book)
    {

        $sql   = 'INSERT INTO books (name,author,year,isbn,pages,description, genreId) VALUES (?,?,?,?,?,?,?)';
        $query = $this->pdo->prepare($sql);
        $result = $query->execute([$book->name,$book->author,$book->year,$book->isbn,$book->pages,$book->description,$book->genre]);

        return $result;

    }

    public function rateBook($rating, $userId)
    {
        $sql   = 'UPDATE user_books SET userRating = ? WHERE userId = ?';
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
