<?php

namespace App\Presenters;

//use App\Model\Entities\Book;
use App\Model\BooksModel;
use App\Model\Entities\Book;
use App\Model\GenresModel;
use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\Image;
use Nette\Utils\Paginator;

/**
 * Base presenter for all application presenters.
 */
class BookPresenter extends Nette\Application\UI\Presenter
{

    private $booksModel;
    private $genresModel;

    public function renderList($orderBy, $order, $orderPrev, $filter,$page = 1)
    {

        if ($orderBy != $orderPrev) {
            $order = "asc";
        }

        $booksCount = $this->booksModel->findBooksCount($filter);

        $paginator = new Paginator();
        $paginator->setItemCount($booksCount);
        $paginator->setItemsPerPage(2);
        $paginator->setPage($page); 
    

        $this->template->books = $this->booksModel->findBooks($orderBy, $order, $filter, $paginator->getLength(), $paginator->getOffset());

        if ($order == "asc") {
            $order = "desc";
        } else {
            $order = "asc";
        }



        $this->template->paginator = $paginator;
        $this->template->orderPrev = $orderBy;
        $this->template->order     = $order;
        $this->template->filter = $filter; 
        $this->template->genres    = $this->genresModel->findGendres();

    }

    public function createComponentFilterForm()
    {
        $form              = new Form;
        $form->onSuccess[] = [$this, 'filterFormSucceeded'];
        return $form;
    }

    public function createComponentDeleteBookFromUserForm()
    {
        $form = new Form;

        $form->onSuccess[] = [$this, 'deleteBookFromUser'];
        return $form;
    }

    public function deleteBookFromUser($form, $values)
    {
        $data   = $form->getHttpData();
        $result = $this->booksModel->deleteBookFromUser($data["bookId"], $this->user->id);
        if ($result) {
            $this->flashMessage('Kniha odebrána z Vašeho seznamu');
        }
        $this->redirect('this');

    }

    public function createComponentAddBookToUserForm()
    {
        $form = new Form;

        $form->onSuccess[] = [$this, 'addBookToUserFormSucceeded'];
        return $form;
    }

    public function addBookToUserFormSucceeded($form, $values)
    {
        $data = $form->getHttpData();

        $result = $this->booksModel->addBookToUser($data["bookId"], $this->user->id);
        if ($result) {
            $this->flashMessage('Kniha přidána do Vašeho seznamu');
        } else {
            $this->flashMessage('Kniha se již ve Vašem seznamu nachází');
        }
        $this->redirect('this');
    }

    public function createComponentAddBookForm()
    {
        $form = new Form;
        $form->addText('name', 'Název Knihy:', 1, 200)
            ->setRequired('Je nutné zadat název knihy');
        $form->addText('author', 'Autor:', 1, 200)
            ->setRequired('Je nutné zadat autora knihy');
        $form->addUpload('image', 'Obrázek(160x100):')
            ->setRequired('Je nutné vybrat obrázek')
            ->addCondition(Form::IMAGE)
            ->addRule(Form::MIME_TYPE, 'Soubor musí být obrázek typu JPEG nebo PNG', array('image/jpeg', 'image/png'))
            ->addRule(Form::MAX_FILE_SIZE, 'Max file size is 514kb.', 514 * 1024);
        $form->addText('year', 'Rok vydání')
            ->setRequired('Je nutné zadat rok vydání knihy')
            ->addRule(Form::INTEGER, 'Rok musí být číslo')
            ->addRule(Form::RANGE, 'Rok musí být v rozsahu 1-' . date("Y"), [1000, date("Y")]);
        $form->addText('pages', 'Počet stran:')
            ->setRequired('Je nutné zadat počet stran')
            ->addRule(Form::INTEGER, 'Rok musí být číslo');
        $form->addText('isbn', 'ISBN:')
            ->setRequired('Je nutné zadat isbn knihy');
        $form->addTextArea('description', 'Popis')
            ->setRequired('Je nuté zadat popis knihy.');

        $genres    = $this->genresModel->findGendres();
        $genresArr = [];
        foreach ($genres as $genre) {
            $genresArr[$genre->id] = $genre->name;
        }
        $form->addSelect('genre', 'Žánr', $genresArr);
        $form->addSubmit('Odeslat');
        $form->onSuccess[] = [$this, 'addBookSucceeded'];
        return $form;
    }

    public function handleRate($id, $rating)
    {
        
        if ($this->user->isLoggedIn()) {  
            $this->booksModel->rateBook($this->user->id, $id, $rating);
        }

    }

    public function renderUserBooks()
    {
        $this->template->books = $this->booksModel->findUsersBooks($this->user->id);
    }

    public function addBookSucceeded($form, $values)
    {

        $image = $values->image->toImage();

        $this->flashMessage('Článek se nepodařilo uložit.', 'error');

        $image->resize(100, 160, Image::STRETCH);

        $imgName = uniqid(rand(0, 20), true) . '.jpg';
        $dir     = 'images/covers/';
        $imgPath = $dir . $imgName;

        $image->save($imgPath, 90, Image::JPEG);

        $book = new Book();

        $book->name        = $values->name;
        $book->author      = $values->author;
        $book->year        = $values->year;
        $book->isbn        = $values->isbn;
        $book->pages       = $values->pages;
        $book->description = $values->description;
        $book->genre       = $values->genre;
        $book->img         = $imgPath;

        $result = $this->booksModel->addBook($book);
        if ($result) {
            $this->flashMessage('Kniha byla uložena');
        }
        $this->redirect('this');

    }

    public function filterFormSucceeded(Form $form)
    {
        $data = $form->getHttpData();

        $this->redirect('this', ["filter" => $data["genres"]]);
    }

    public function renderShow($id)
    {
      
        if ($this->user->isLoggedIn()) {
           $userId = $this->user->id;
        }
        else
        {
           $userId = 0; 
        }
        $this->template->book   = $this->booksModel->findBook($id,$userId);
    }

    public function injectGenresModel(GenresModel $genresModel)
    {
        $this->genresModel = $genresModel;
    }

    public function injectBooksModel(BooksModel $booksModel)
    {
        $this->booksModel = $booksModel;
    }

}
