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
		if (isset($this->params['book'])) trigger_error('Variable $book overwritten in foreach on line 4');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<div class="container"> 
<div class = "row"> 
<?php
		$iterations = 0;
		foreach ($books as $book) {
?>
 <div class = "col-sm-3 text-center">
   <table>
   	<tbody>
   	 <tr><td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:show", ['id'=>$book->id])) ?>"> <?php
			echo LR\Filters::escapeHtmlText($book->name) /* line 8 */ ?> </a></tr></td>
   	 <tr><td><img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath.'/'.$book->img)) /* line 9 */ ?>" alt="<?php
			echo LR\Filters::escapeHtmlAttr($book->name) /* line 9 */ ?> přebal" height="160" width="100"></tr></td>
   	 <tr><td> <?php
			/* line 10 */
			echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["deleteBookFromUserForm"], []);
?>

          <input type="hidden" name="bookId" value="<?php echo LR\Filters::escapeHtmlAttr($book->id) /* line 11 */ ?>">
          <input type = "submit" value = "odebrat">
     <?php
			echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

     </tr></td>
     </tbody>
   </table>
 </div>
<?php
			$iterations++;
		}
?>
</div>
</div>


<?php
	}

}
