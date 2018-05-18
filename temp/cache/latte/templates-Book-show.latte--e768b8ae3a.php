<?php
// source: C:\xampp\htdocs\bookhero\app\presenters/templates/Book/show.latte

use Latte\Runtime as LR;

class Templatee768b8ae3a extends Latte\Runtime\Template
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
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		?><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'name', 'order'=>'asc'])) ?>">Zpět</a>
<h2><?php echo LR\Filters::escapeHtmlText($book->name) /* line 3 */ ?></h2>
<div>
	<img> </img>
</div>
<div>
<table>
	<tr>
		<td>Autor</td>
		<td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 11 */ ?></td>
	<tr>
	<tr>
		<td>Stran</td>
		<td><?php echo LR\Filters::escapeHtmlText($book->pages) /* line 15 */ ?></td>
	<tr>
	<tr>
		<td>Žánr</td>
		<td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 19 */ ?></td>
	<tr>
	<tr>
		<td>ISBN</td>
		<td><?php echo LR\Filters::escapeHtmlText($book->isbn) /* line 23 */ ?></td>
	<tr>	
	<tr>
		<td>Autor</td>
		<td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 27 */ ?></td>
	<tr>
</table>
<div><?php echo LR\Filters::escapeHtmlText($book->description) /* line 30 */ ?></div>
<div><?php
	}

}
