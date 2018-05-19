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
		if (isset($this->params['book'])) trigger_error('Variable $book overwritten in foreach on line 27');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

 <?php
		/* line 3 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["filterForm"], []);
?>

  <select name = "genres">
    <option> </option>
<?php
		$iterations = 0;
		foreach ($genres as $genre) {
			?>    <option value= "<?php echo LR\Filters::escapeHtmlAttr($genre->id) /* line 7 */ ?>" > <?php echo LR\Filters::escapeHtmlText($genre->name) /* line 7 */ ?> </option>
<?php
			$iterations++;
		}
?>
  </select>
  <input type = "submit">
 <?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>


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
				echo LR\Filters::escapeHtmlText($book->name) /* line 29 */ ?></a></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 30 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->year) /* line 31 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($book->isbn) /* line 32 */ ?></td>
<?php
				if ($user->isLoggedIn()) {
?>
      <td> 
        <?php
					/* line 35 */
					echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["addBookToUserForm"], []);
?>

          <input type="hidden" name="bookId" value="<?php echo LR\Filters::escapeHtmlAttr($book->id) /* line 36 */ ?>">
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
