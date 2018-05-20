<?php

namespace App\Model\Entities;

/**
 * Class Article
 * @package App\Model\Entities
 * @property int $id
 * @property string $name
 * @property string $author
 * @property int $year
 * @property string $description
 * @property int $pages
 * @property string $isbn
 * @property string $category
 * @property string $userRating 
 * @property int $rating 
 * @property string|null $img

 */
class Book{




  /**
   * Funkce vracející pole s daty pro ukládání v DB
   * @return array
   */
  public function getDataArr(){
    $result=[
      'name'=>@$this->name,
      'author'=>@$this->author,
      'year'=>@$this->year,
      'description'=>@$this->description,
      'pages'=>@$this->pages,
      'isbn'=>@$this->isbn,
      'img'=>@$this->img,
      'genre'=>@$this->genre,
      'rating' =>@$this->userRating,
    ];
    if (!empty($this->id)){
      $result['id']=$this->id;
    }
    return $result;
  }

}