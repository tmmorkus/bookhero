<?php
// source: /home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/app/presenters/templates/Book/list.latte

use Latte\Runtime as LR;

class Templatefd966dc20a extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['genre'])) trigger_error('Variable $genre overwritten in foreach on line 7');
		if (isset($this->params['uBook'])) trigger_error('Variable $uBook overwritten in foreach on line 45');
		if (isset($this->params['book'])) trigger_error('Variable $book overwritten in foreach on line 35');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
  <h1>Seznam knih</h1>
  <label for="genreSelect">Filtr dle žánru: </label> 
  <select id = "genreSelect" class="custom-select" name="forma" onchange="location = this.value;">
    <option <?php
		if (empty($filter)) {
			?>selected<?php
		}
		?>  value= "<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['page'=>1,'orderBy'=>'name', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>" >vypnout filtr</option>

<?php
		$iterations = 0;
		foreach ($genres as $genre) {
			?>    <option <?php
			if ($genre->id == $filter) {
				?>selected<?php
			}
			?>  value= "<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['page'=>1,'filter'=>$genre->id,'orderBy'=>'name', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>" > <?php
			echo LR\Filters::escapeHtmlText($genre->name) /* line 8 */ ?> </option>
<?php
			$iterations++;
		}
?>
  </select>



<?php
		if (!empty($books)) {
?>
    
    
  <table class="table table-hover">
  <thead>
     <tr>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'name', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Název</a></th>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'author', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Autor</a></th>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'year', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Rok vydání</a></th>
      <th>ISBN</th>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'rating', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Hodnocení</a></th>
<?php
			if ($user->isLoggedIn()) {
?>
      <th></th>
<?php
			}
			if ($user->isInRole('admin') == 1) {
?>
      <th></th>
      <th></th>
<?php
			}
?>
    </tr>
  </thead>
   <tbody>
<?php
			$iterations = 0;
			foreach ($books as $book) {
?>
     <tr>
      <td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:show", ['id'=>$book->id])) ?>"><?php
				echo LR\Filters::escapeHtmlText($book->name) /* line 37 */ ?></a></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 38 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->year) /* line 39 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->isbn) /* line 40 */ ?></td>
      <td><?php
				if (empty($book->rating)) {
					?>-<?php
				}
				else {
					echo LR\Filters::escapeHtmlText($book->rating) /* line 41 */ ?>%<?php
				}
?></td>
<?php
				if ($user->isLoggedIn()) {
?>
      <td>
<?php
					$change = false;
					$iterations = 0;
					foreach ($userBooks as $uBook) {
						if ($uBook->id == $book->id) {
							$change = true;
						}
						$iterations++;
					}
					if ($change == false) {
						?>          <a  href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("addBookToUser!", ['bookId' => $book->id])) ?>">Přidat do seznamu</a>
<?php
					}
					else {
						?>          <a onclick="return confirm('Opravdu chcete knihu odebraz ze seznamu?')" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteBookFromUser!", ['bookId' => $book->id])) ?>">Odebrat ze seznamu</a>
<?php
					}
?>
      </td>
<?php
				}
				if ($user->isInRole('admin') == 1) {
?>
       <td> 
         <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:edit", ['id' => $book->id])) ?>">Editovat</a>
       </td>
       <td> 
        <a onclick="return confirm('Opravdu chcete knihu smazat?')" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteBook!", ['bookId' => $book->id, 'imgPath' => $book->img])) ?>">Smazat</a>
       </td>
<?php
				}
?>
       </tr>
<?php
				$iterations++;
			}
?>
    </tbody>  
    </table>
    <div class="pagination">
<?php
			if (!$paginator->isFirst()) {
				?>        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("list", [1, 'orderBy'=>$orderPrev,'filter'=>$filter,'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">První</a>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("list", ['page' => $paginator->page-1, 'orderBy'=>$orderPrev,'filter'=>$filter,'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Předchozí</a>
        &nbsp;|&nbsp;
<?php
			}
?>

    Stránka <?php echo LR\Filters::escapeHtmlText($paginator->page) /* line 77 */ ?> z <?php echo LR\Filters::escapeHtmlText($paginator->pageCount) /* line 77 */ ?>

<?php
			if (!$paginator->isLast()) {
?>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("list", ['page' => $paginator->page+1, 'orderBy'=>$orderPrev,'filter'=>$filter,'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Další</a>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("list", ['page' => $paginator->pageCount,'orderBy'=>$orderPrev,'filter'=>$filter,'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Poslední</a>
<?php
			}
?>
</div>
<?php
		}
		else {
?>
    <p>V seznamu nejsou žádné knihy</p>
<?php
		}
?>

<?php
	}

}
