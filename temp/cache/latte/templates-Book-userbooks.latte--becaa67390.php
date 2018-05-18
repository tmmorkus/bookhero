<?php
// source: C:\xampp\htdocs\bookhero\app\presenters/templates/Book/userbooks.latte

use Latte\Runtime as LR;

class Templatebecaa67390 extends Latte\Runtime\Template
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
		if (isset($this->params['book'])) trigger_error('Variable $book overwritten in foreach on line 2');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		$iterations = 0;
		foreach ($books as $book) {
			?> <div><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:show", ['id'=>$book->id])) ?>"> <?php
			echo LR\Filters::escapeHtmlText($book->name) /* line 3 */ ?> </a></div>
         <?php
			/* line 4 */
			echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["deleteBookFromUserForm"], []);
?>

          <input type="hidden" name="bookId" value="<?php echo LR\Filters::escapeHtmlAttr($book->id) /* line 5 */ ?>">
          <input type = "submit" value = "odebrat">
        <?php
			echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

<?php
			$iterations++;
		}
		
	}

}
