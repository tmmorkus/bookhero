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

    public function findBook($id,$userId)
    {
        $param = [];
        $param[]=$id;
        if ($userId > 0) {
            
            $sql = 'select books.*, user_books.userRating as userRating from books left join 
            user_books on books.id = user_books.bookId where books.id = ? and user_books.userId = ?';
            $param[] = $userId;
        }
        else
        {
           $sql = 'SELECT * FROM books where id =?';
           
        }
        

        $query = $this->pdo->prepare($sql);
        $query->execute($param);
        return $query->fetchObject(__NAMESPACE__ . '\Entities\Book');
    }

    public function findBooksCount($filter)
    {
        $sql = 'SELECT COUNT(*) FROM books ';
        if (!empty($filter)) {
          $sql .= 'where genreId = :genreId';
        }
        
        $query = $this->pdo->prepare($sql);
        if (!empty($filter)) {
          $query->bindParam(':genreId',$filter,PDO::PARAM_INT);
        }
       $query->execute();
       return $query->fetchColumn();

    }

    public function findBooks($orderBy, $order, $filter,$limit,$offset)
    {
        $param = [];
        $sql = 'select books.*, FLOOR(((SUM(user_books.userRating = 1)/COUNT(user_books.userRating)) 
* 100)) as rating from books left join user_books on user_books.bookId = books.id ';
        if (!empty($filter)) {
            $sql .= 'WHERE books.genreId = :genreId ';
        }

        if (!(in_array($orderBy, ["name", "author", "year", "rating"]) && in_array($order, ["asc", "desc"]))) {
           $orderBy = 'name';
           $order =  'asc'; 
        }

         $sql .= 'GROUP BY books.id '; 

         $sql .= 'ORDER BY ' . $orderBy . " " . $order;

         $sql .= ' LIMIT :limit OFFSET :offset';
  
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':offset',$offset,PDO::PARAM_INT);
        $query->bindParam(':limit',$limit,PDO::PARAM_INT);
        if (!empty($filter)) {
          $query->bindParam(':genreId',$filter,PDO::PARAM_INT);
        }
        $query->execute();
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

        $sql   = 'INSERT INTO books (name,author,year,isbn,pages,description, genreId, img) VALUES (?,?,?,?,?,?,?,?)';
        $query = $this->pdo->prepare($sql);
        $result = $query->execute([$book->name,$book->author,$book->year,$book->isbn,$book->pages,$book->description,$book->genre, $book->img]);

        return $result;

    }


    public function findRating($userId, $bookId)
    {
       $sql = 'select userRating from user_books where userId = ? and bookId = ?';
       $query = $this->pdo->prepare($sql);
       return $query->execute([$userId,$bookId]);
    }

    public function rateBook($userId,$bookId,$rating)
    {

        $sql   = 'UPDATE user_books SET userRating = ? WHERE userId = ? and bookId = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute([$rating, $userId,$bookId]);
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
