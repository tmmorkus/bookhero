<?php
// source: C:\xampp\htdocs\bookhero\app\presenters/templates/Book/userBooks.latte

use Latte\Runtime as LR;

class Template4a9712f50c extends Latte\Runtime\Template
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
		if (isset($this->params['genre'])) trigger_error('Variable $genre overwritten in foreach on line 8');
		if (isset($this->params['book'])) trigger_error('Variable $book overwritten in foreach on line 15');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<h1>Uživatelský seznam</h1>
<div class="container">
  <label for="genreSelect">Filtr dle žánru: </label> 
  <select id = "genreSelect" class ="marBot custom-select" name="forma" onchange="location = this.value;">
    <option <?php
		if (empty($filter)) {
			?>selected<?php
		}
		?> value= "<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:UserBooks")) ?>">vypnout filtr</option>

<?php
		$iterations = 0;
		foreach ($genres as $genre) {
			?>    <option <?php
			if ($genre->id == $filter) {
				?>selected<?php
			}
			?>  value= "<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:UserBooks", ['filter'=>$genre->id])) ?>" > <?php
			echo LR\Filters::escapeHtmlText($genre->name) /* line 9 */ ?> </option>
<?php
			$iterations++;
		}
?>
  </select>
<?php
		if (!empty($books)) {
?>

<div class = "row"> 
<?php
			$iterations = 0;
			foreach ($books as $book) {
?>
 <div class = "col-md-3 col-sm-4 col-xs-6  text-center">
   <table class="marBot">
   	<tbody>
   	 <tr><td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:show", ['id'=>$book->id])) ?>"> <?php
				echo LR\Filters::escapeHtmlText($book->name) /* line 19 */ ?> </a></td></tr>
   	 <tr><td><img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath.'/'.$book->img)) /* line 20 */ ?>" alt="<?php
				echo LR\Filters::escapeHtmlAttr($book->name) /* line 20 */ ?> přebal" height="160" width="100"></td></tr>
   	 <tr><td> 
          <a  href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteBookFromUser!", ['bookId' => $book->id])) ?>">Odebrat ze seznamu</a>
     </td></tr>
     </tbody>
   </table>
 </div>
<?php
				$iterations++;
			}
?>


</div>

<div class="pagination text-center col-sm-12">
<?php
			if (!$paginator->isFirst()) {
				?>        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("userBooks", [1, 'filter'=>$filter])) ?>">První</a>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("userBooks", ['page' => $paginator->page-1, 'filter'=>$filter])) ?>">Předchozí</a>
        &nbsp;|&nbsp;
<?php
			}
?>

    Stránka <?php echo LR\Filters::escapeHtmlText($paginator->page) /* line 40 */ ?> z <?php echo LR\Filters::escapeHtmlText($paginator->pageCount) /* line 40 */ ?>

<?php
			if (!$paginator->isLast()) {
?>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("userBooks", ['page' => $paginator->page+1,'filter'=>$filter])) ?>">Další</a>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("userBooks", ['page' => $paginator->pageCount,'filter'=>$filter])) ?>">Poslední</a>
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
</div>


<?php
	}

}
