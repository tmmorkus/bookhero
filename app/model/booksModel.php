<?php

namespace App\Model;

use App\Model\Entities\Book;
use \PDO;


class BooksModel
{
    /** @var PDO $pdo */
    private $pdo;

    public function findUsersBooks($userId,$bookId)
    {
        
        $param = [];
        $param[] = $userId;

        $sql = 'SELECT books.* FROM books join user_books on books.id = user_books.bookId WHERE user_books.userId = ? ';
        
        if (!empty($bookId)) {
            $sql .= 'and user_books.BookId = ?';
            $param[] = $bookId;
        }

        $query = $this->pdo->prepare($sql); 

        $query->execute($param);
        return $query->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\Entities\Book');

    }



    public function findBook($id,$userId)
    {
        $param = [];
     
        if ($userId > 0) {
             
            $sql = 'select books.*, FLOOR(((SUM(user_books.userRating = 1)/
            COUNT(user_books.userRating)) * 100)) as rating, ub.userRating as userRating,
            group_concat(book_genres.genreId) as genres 
            from books 
            left join user_books ub on ub.bookId = books.id and ub.userId = ? 
            left join  user_books on user_books.bookId = books.id 
            join book_genres on books.id = book_genres.bookId
            where books.id = ?';
            $param[] = $userId;  
            $param[]=$id;
        }
        else
        {
           $sql = 'select books.*, FLOOR(((SUM(user_books.userRating = 1)/COUNT(user_books.userRating)) * 100)) as rating,
           group_concat(book_genres.genreId) as genres from books 
           left join user_books on user_books.bookId = books.id 
           join book_genres on books.id = book_genres.bookId
           where books.id = ? ';
           $param[]=$id;
        }
        

        $query = $this->pdo->prepare($sql);
        $query->execute($param);
        return $query->fetchObject(__NAMESPACE__ . '\Entities\Book');
    }

    public function findByName($bookName)
    {


        $sql = 'SELECT books.* FROM books where books.name = ?'; 
    
    
        $query = $this->pdo->prepare($sql);
        $query->execute([$bookName]);
        return $query->fetchObject(__NAMESPACE__ . '\Entities\Book');
    }

    public function findBooksCount($filter, $userId)
    {
        
        $params = []; 
        $sql = 'SELECT COUNT(*) from
        (select books.id from books 
        join book_genres on book_genres.bookId = books.id ';

        
       if (!empty($userId)) {
          $sql .= 'inner join user_books on books.Id = user_books.bookId where user_books.userId = ? ';
          $params[] = $userId;
        }
        
        if (!empty($filter)) {
          if (!empty($userId))
          {
            $sql .= 'and book_genres.genreId = ?';
          } 
          else
          {
            $sql .= 'where book_genres.genreId = ?';
          }
          
          $params[] = $filter;
        }
        
        $sql .= ' GROUP BY books.Id) sub';

        $query = $this->pdo->prepare($sql); 
       $query->execute($params);

       return $query->fetchColumn();

    }

    public function autocomplete($term)
    {
        $term .= '%';
        $sql = "SELECT name as value, name as lalbel, id  FROM books WHERE name LIKE ? limit 0,7"; 
        $query = $this->pdo->prepare($sql); 
        $query->execute([$term]);
        $result = [];
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result; 

    }

    public function findBooks($orderBy, $order, $filter,$limit,$offset,$userId)
    {
       
  
        $sql = 'select books.*, FLOOR(((SUM(user_books.userRating = 1)/COUNT(user_books.userRating)) 
        * 100)) as rating,
        group_concat(book_genres.genreId) as genres from books 
        left join user_books on user_books.bookId = books.id
        join book_genres on books.id = book_genres.bookId ';
       
        if (!empty($userId))
        {
            $sql .= 'join user_books ub on ub.bookId = books.Id ';
            $sql .= 'where ub.userId = :userId ';
         }      

        if (!empty($filter)) {
            if (!empty($userId))
            {
                $sql .= 'and book_genres.genreId = :genreId ';
            }
            else 
            {
               $sql .= 'WHERE book_genres.genreId = :genreId '; 
            }
            
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
        if (!empty($userId)) {
          $query->bindParam(':userId',$userId,PDO::PARAM_INT);
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

    public function deleteBook ($bookId)
    {
        $sql = 'DELETE FROM user_books WHERE bookId = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute([$bookId]);

        $sql = 'DELETE FROM book_genres WHERE bookId = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute([$bookId]);

        $sql = 'DELETE FROM books WHERE id = ?';
        $query = $this->pdo->prepare($sql);
        $result = $query->execute([$bookId]);
        return $result; 
    }

    public function addBook(Book $book)
    {
  



        $sql   = 'INSERT INTO books (name,author,year,isbn,pages,description,img) VALUES (?,?,?,?,?,?,?)';
        $query = $this->pdo->prepare($sql);
        $result = $query->execute([$book->name,$book->author,$book->year,$book->isbn,$book->pages,$book->description,$book->img]);
        $lastId  = $this->pdo->lastInsertId();
        foreach ($book->genres as $genreId) {
            
            $sql   = 'INSERT INTO book_genres (bookId, genreId) VALUES (?,?)';
            $query = $this->pdo->prepare($sql);
            $result = $query->execute([$lastId,$genreId]);
        }
      
        return $result;

    }

    public function editBook(Book $book)
    {
        $sql   = "DELETE FROM book_genres WHERE bookId = ?";
             
        $query = $this->pdo->prepare($sql);
        $query->execute([$book->id]); 

        foreach ($book->genres as $genre) {
        $sql   = "INSERT INTO book_genres (bookId, genreId) VALUES (?,?)";
             
        $query = $this->pdo->prepare($sql);
        $query->execute([$book->id, $genre]);
        }

        $param = [$book->name,$book->author,$book->year,$book->isbn,$book->pages,$book->description];

         $sql   = "UPDATE books SET name = ? , author = ? , year = ? , isbn = ? , pages = ? , description = ? ";

         if (!empty($book->img))
         {
            $sql .= ",img = ? ";
            $param[] = $book->img; 

         }

         $sql .= "WHERE id = ?";
         $param[] = $book->id;

        $query = $this->pdo->prepare($sql);
        $result = $query->execute($param);
   
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
