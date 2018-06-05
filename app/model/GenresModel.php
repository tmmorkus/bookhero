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
    $query=$this->pdo->prepare('SELECT * FROM genres ORDER BY name;');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__.'\Entities\Genre');
    }

    public function findGendresToRender($limit,$offset){
    
    $query=$this->pdo->prepare('SELECT * FROM genres ORDER BY name LIMIT :limit OFFSET :offset;');
    $query->bindParam(':offset',$offset,PDO::PARAM_INT);
    $query->bindParam(':limit',$limit,PDO::PARAM_INT);
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
        $sql = 'DELETE FROM book_genres WHERE genreId = ?';
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

    public function genresCount()
    {
        $sql   = 'SELECT COUNT(*) from genres';
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
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
