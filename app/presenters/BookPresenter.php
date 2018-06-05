<?php

namespace App\Presenters;

use App\Model\BooksModel;
use App\Model\Entities\Book;
use App\Model\Entities\Genre;
use App\Model\GenresModel;
use Czubehead\BootstrapForms\BootstrapForm;
use Czubehead\BootstrapForms\Enums\RenderMode;
use Nette;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\Image;
use Nette\Utils\Paginator;
use Nette\Utils\FileSystem;

/**
 * Base presenter for all application presenters.
 */
class BookPresenter extends Nette\Application\UI\Presenter
{

    private $booksModel;
    private $genresModel;

    public function handleDeleteBookFromUser($bookId)
    {
        if ($this->user->isLoggedIn()) {
            $result = $this->booksModel->deleteBookFromUser($bookId, $this->user->id);
            if ($result) {
                $this->flashMessage('Kniha odebrána z Vašeho seznamu');
            }
        }

    }

    public function handleDeleteBook($bookId, $imgPath)
    {

        if ($this->user->isInRole('admin') == 1) {
            $result = $this->booksModel->deleteBook($bookId);
            if ($result) {
                FileSystem::delete($imgPath);
                $this->flashMessage('Kniha smazána');
            }
        }

    }

    public function actionEdit($id)
    {

        if ($this->user->isInRole('admin') == 1) {
            $book = $this->booksModel->findBook($id, null);

            $this['addBookForm']->setDefaults($book->getDataArr());
        }
    }

    public function handleAddBookToUser($bookId)
    {
        if ($this->user->isLoggedIn()) {
            $result = $this->booksModel->addBookToUser($bookId, $this->user->id);
            if ($result) {
                $this->flashMessage('Kniha přidána do Vašeho seznamu');
            } 
        }
    }

    public function createComponentGenreAddForm()
    {
        $form = new BootstrapForm;

        $form->addText('genreName', 'Název žánru:', 50)
            ->setRequired('Je nutné zadat název knihy')
            ->addRule(function (TextInput $input) {
                return !($this->genresModel->findGenre([$input->value, "name"]));
            }, 'Žánr již existuje');
        $form->addSubmit('Odeslat');
        $form->onSuccess[] = [$this, 'addGenreSucceeded'];
        return $form;
    }

    public function addGenreSucceeded($form, $values)
    {

        $genre       = new Genre();
        $genre->name = $values->genreName;

        $result = $this->genresModel->addgenre($genre);
        if ($result) {
            $this->flashMessage('žánr uložen');
        }
        $this->redirect('this');

    }

    public function createComponentAddBookForm()
    {

        $form             = new BootstrapForm;
        $form->renderMode = RenderMode::SideBySideMode;

        $form->addText('name', 'Název Knihy:', 50)
            ->setRequired('Je nutné zadat název knihy')
            ->addRule(function (TextInput $input) {
                return (empty($this->booksModel->findByName($input->value)) || strpos($_SERVER['REQUEST_URI'], '/edit/') != false);
            }, 'Kniha s tímto názvem již existuje');

        $form->addText('author', 'Autor:', 50)
            ->setRequired('Je nutné zadat autora knihy');
        if (strpos($_SERVER['REQUEST_URI'], '/edit/') === false) {
            $form->addUpload('image', 'Obrázek(160x100):')
                ->setRequired('Je nutné vybrat obrázek')
                ->addRule(BootstrapForm::IMAGE, 'Obrázek musí být ve formátu musí být JPEG, PNG nebo GIF.')
                ->addRule(BootstrapForm::MAX_FILE_SIZE, 'Max file size is 514kb.', 514 * 1024);
        }
        elseif (strpos($_SERVER['REQUEST_URI'], '/edit/') > 0)
        {
                $form->addUpload('image', 'Obrázek(160x100):')
                ->setRequired(false)
                ->addRule(BootstrapForm::IMAGE, 'Obrázek musí být ve formátu musí být JPEG, PNG nebo GIF.')
                ->addRule(BootstrapForm::MAX_FILE_SIZE, 'Max file size is 514kb.', 514 * 1024);
        }

        $form->addText('year', 'Rok vydání:')
            ->setRequired('Je nutné zadat rok vydání knihy')
            ->addRule(BootstrapForm::INTEGER, 'Rok musí být číslo')
            ->addRule(BootstrapForm::RANGE, 'Rok musí být v rozsahu 0-' . date("Y"), [0, date("Y")]);
        $form->addText('pages', 'Počet stran:')
            ->setRequired('Je nutné zadat počet stran')
            ->addRule(BootstrapForm::INTEGER, 'Rok musí být číslo');
        $form->addText('isbn', 'ISBN:')
            ->setRequired('Je nutné zadat isbn knihy')
            ->addRule(BootstrapForm::MIN_LENGTH, 'ISBN musí mít min. %d znaků', 6);
        $form->addTextArea('description', 'Popis:')
            ->setRequired('Je nuté zadat popis knihy.');

        $genres    = $this->genresModel->findGendres();
        $genresArr = [];
        foreach ($genres as $genre) {
            $genresArr[$genre->id] = $genre->name;
        }
        $form->addCheckboxList('genres', 'Žánry:', $genresArr)
            ->setRequired('Je nuté zadat popis knihy.')
            ->setAttribute('class', 'jsss');
        //$form->addSelect('genre', 'Žánr', $genresArr);
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
    public function handleDeleteGenre($genreId)
    {
        if ($this->user->isInRole('admin') == 1) {
            $result = $this->genresModel->deleteGenre($genreId);
            if ($result) {
                $this->flashMessage('Žánr odebrán');
            } else {
                $this->flashMessage('Žánr se nepodařilo odebrat');
            }
        }
    }

    public function renderAddGenre($page = 1)
    {

        $genresCount = $this->genresModel->genresCount();

        $paginator = new Paginator();
        $paginator->setItemCount($genresCount);
        $paginator->setItemsPerPage(5);
        $paginator->setPage($page);


        if ($this->user->isInRole('admin') == 1) {
            $this->template->genres = $this->genresModel->findGendresToRender($paginator->getLength(), $paginator->getOffset());
               $this->template->paginator = $paginator; 
        } else {
            $this->redirect('Book:list');
        }
    }

    public function renderUserBooks($filter, $page = 1)
    {
        if ($this->user->isLoggedIn()) {
            $books                     = $this->getBooks("name", "asc", $filter, 8, $page, $this->user->id);
            $this->template->books     = $books[1];
            $this->template->genres    = $this->genresModel->findGendres();
            $this->template->filter    = $filter;
            $this->template->paginator = $books[0];
        } else {
            $this->redirect("Book:list");
        }
    }

    private function getBooks($orderBy, $order, $filter, $itemsNumb, $page, $user)
    {
        $booksCount = $this->booksModel->findBooksCount($filter, $user);

      
        $paginator = new Paginator();
        $paginator->setItemCount($booksCount);
        $paginator->setItemsPerPage($itemsNumb);
        $paginator->setPage($page);

        $returnArr   = [];
        $returnArr[] = $paginator;
        $returnArr[] = $this->booksModel->findBooks($orderBy, $order, $filter, $paginator->getLength(), $paginator->getOffset(), $user);
        if ($this->user->isLoggedIn()) {
            $returnArr[] = $this->booksModel->findUsersBooks($this->user->id, null);
        } else {
            $returnArr[] = "";
        }
        return $returnArr;

    }

    public function renderList($orderBy, $order, $orderPrev, $filter, $page = 1)
    {



        if ($page == 2 && $order == "asc") {
            $order = "desc";
        }
        elseif ($page == 2  && $order == "desc")
        {
            $order = "asc";
        }
    

        $books = $this->getBooks($orderBy, $order, $filter, 6, $page, null);

        $this->template->books = $books[1];

        if ($page == 1)
        {
          if ($order == "desc") {
              $order = "asc";
          } else {
            $order = "desc";
          }
        }
        $this->template->paginator = $books[0];
        $this->template->orderPrev = $orderBy;
        $this->template->order     = $order;
        $this->template->filter    = $filter;
        $this->template->genres    = $this->genresModel->findGendres();
        $this->template->userBooks = $books[2];

    }

    public function addBookSucceeded($form, $values)
    {

        $book = new Book();
         
 

        if ($values->image->isOK()) {
            
            $image = $values->image->toImage();

            $image->resize(100, 160, Image::STRETCH);

            $imgName = uniqid(rand(0, 20), true) . '.jpg';
            $dir     = 'images/covers/';
            $imgPath = $dir . $imgName;

            $image->save($imgPath, 90, Image::JPEG);
            $book->img = $imgPath;
        }

        $book->name        = $values->name;
        $book->author      = $values->author;
        $book->year        = $values->year;
        $book->isbn        = $values->isbn;
        $book->pages       = $values->pages;
        $book->description = $values->description;
        $book->genres      = $values->genres;

        if (strpos($_SERVER['REQUEST_URI'], '/edit/') != false
            && !empty($this->booksModel->findByName($book->name)->id)) {
            $oldBook = $this->booksModel->findByName($book->name);
            $book->id = $oldBook->id;
            if (!empty($book->img))
            {
                FileSystem::delete($oldBook->img);
            }
            $result = $this->booksModel->editBook($book);
            if ($result) {
                $this->flashMessage('Kniha byla pozměněna');
                $this->redirect('Book:list');
            }

        } elseif (strpos($_SERVER['REQUEST_URI'], '/edit/') === false) {
            $result = $this->booksModel->addBook($book);
            if ($result) {
                $this->flashMessage('Kniha byla uložena');
            }
            $this->redirect('this');
        } else {
            $this->flashMessage('Hledaná kniha neexistuje!');
        }

    }

    public function filterFormSucceeded(Form $form)
    {
        $data = $form->getHttpData();

        $this->redirect('this', ["filter" => $data["genres"]]);
    }

    public function handleAutocomplete($term)
    {

        $result = $this->booksModel->autocomplete($term);

        if (!empty($result)) {

            $this->sendResponse(new JsonResponse($result));
        }
    }

    public function renderShow($id, $rating)
    {

        if (!empty($id) && !empty($this->booksModel->findBook($id, 0)->id)) {

            if ($this->user->isLoggedIn()) {
                $userId = $this->user->id;
            } else {
                $userId = 0;
            }

            $this->template->actualRating = $rating;

            $userBook = "";
            if ($this->user->isLoggedIn()) {

                $userBook = $this->booksModel->findUsersBooks($this->user->id, $id);

            }
            $book =  $this->booksModel->findBook($id, $userId);
            $booksGenres = "";

        
            foreach ($book->genres as $genre) {
              $booksGenres .= $this->genresModel->findGenre([$genre, "id"])->name . ", ";
            }
            $booksGenres = substr($booksGenres, 0, -2);

            $this->template->genres = $booksGenres;

            $this->template->userBook = $userBook;

            $this->template->book = $book;
        } else {
            $this->flashMessage('Kniha neexistuje');
            $this->redirect('Book:list');

        }
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
