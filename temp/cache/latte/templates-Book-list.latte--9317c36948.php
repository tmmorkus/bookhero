<?php
// source: C:\xampp\htdocs\bookhero\app\presenters/templates/Book/list.latte

use Latte\Runtime as LR;

class Template9317c36948 extends Latte\Runtime\Template
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
		if (isset($this->params['genre'])) trigger_error('Variable $genre overwritten in foreach on line 6');
		if (isset($this->params['book'])) trigger_error('Variable $book overwritten in foreach on line 28');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

  <select name="forma" onchange="location = this.value;">
    <option <?php
		if (empty($filter)) {
			?>selected<?php
		}
		?>  value= "<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['page'=>1,'orderBy'=>'name', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>" > </option>

<?php
		$iterations = 0;
		foreach ($genres as $genre) {
			?>    <option <?php
			if ($genre->id == $filter) {
				?>selected<?php
			}
			?>  value= "<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['page'=>1,'filter'=>$genre->id,'orderBy'=>'name', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>" > <?php
			echo LR\Filters::escapeHtmlText($genre->name) /* line 7 */ ?> </option>
<?php
			$iterations++;
		}
?>
  </select>



<?php
		if (!empty($books)) {
?>
    
    
  <table>
  <thead>
     <tr>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'name', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Název</a></th>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'author', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Autor</a></th>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'year', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Rok vydání</a></th>
      <th>ISBN</th>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'rating', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Hodnocení</a></th>
      <th> </th>
    </tr>
  </thead>
   <tbody>
<?php
			$iterations = 0;
			foreach ($books as $book) {
?>
     <tr>
      <td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:show", ['id'=>$book->id])) ?>"><?php
				echo LR\Filters::escapeHtmlText($book->name) /* line 30 */ ?></a></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 31 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->year) /* line 32 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->isbn) /* line 33 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->rating) /* line 34 */ ?>%</td>
<?php
				if ($user->isLoggedIn()) {
?>
      <td> 
        <?php
					/* line 37 */
					echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["addBookToUserForm"], []);
?>

          <input type="hidden" name="bookId" value="<?php echo LR\Filters::escapeHtmlAttr($book->id) /* line 38 */ ?>">
          <input type = "submit" value = "přidat do kolekce">
        <?php
					echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

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

    Stránka <?php echo LR\Filters::escapeHtmlText($paginator->page) /* line 55 */ ?> z <?php echo LR\Filters::escapeHtmlText($paginator->pageCount) /* line 55 */ ?>

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
