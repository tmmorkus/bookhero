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


    /**
     * ArticlesModel constructor
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

}
