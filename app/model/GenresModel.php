<?php

namespace App\Model;

use App\Model\Entities\Genre;
use \PDO;

/**
 * Class GenreModel - třída modelu pro práci s články v DB
 * @package App\Model
 */
class GenresModel
{
    /** @var PDO $pdo */
    private $pdo;

    public function findGendres(){
    $query=$this->pdo->prepare('SELECT * FROM genres ORDER BY `name`;');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__.'\Entities\Genre');
    }




    public function findGenre($genre)
    {
    
    $sql = 'SELECT * FROM genres ';

    if ($genre[1] == "id") {
        $sql .= "where id = ?"; 
    }
    else 
    {
        $sql .= "where name = ?";
    }



    $query=$this->pdo->prepare($sql);

    $query->execute([$genre[0]]);
    return $query->fetchObject(__NAMESPACE__ . '\Entities\Genre');
    }


    public function deleteGenre($id)
    {
        $sql = 'DELETE FROM user_books WHERE genreId = ?';
        $query = $this->pdo->prepare($sql);
        $query->execute([$id]);

        $sql   = 'DELETE FROM genres WHERE id = ?';
        $query = $this->pdo->prepare($sql);
        $result = $query->execute([$id]);
        return $result;
    }
    public function addGenre($genre)
    {
        $sql   = 'INSERT INTO genres (name) VALUES (?)';
        $query = $this->pdo->prepare($sql);
        $result = $query->execute([$genre->name]);
        return $result;
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
