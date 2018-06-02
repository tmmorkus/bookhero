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
?>
<div class = "container">
	<h2><?php echo LR\Filters::escapeHtmlText($book->name) /* line 3 */ ?></h2>
	<div class = "row">

		<div class = "col-lg-2 col-md-3 col-sm-4">
			<img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath.'/'.$book->img)) /* line 7 */ ?>" alt="<?php
		echo LR\Filters::escapeHtmlAttr($book->name) /* line 7 */ ?> přebal" height="160" width="100">
		</div>
		<div class = "col-lg-10 col-md-9 col-sm-8">
		<table>
			<tr>
				<td class="font-weight-bold">Autor: </td>
				<td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 13 */ ?></td>
			<tr>
			<tr>
				<td class="font-weight-bold">Stran: </td>
				<td><?php echo LR\Filters::escapeHtmlText($book->pages) /* line 17 */ ?></td>
			<tr>
			<tr>
				<td class="font-weight-bold">Žánr: </td>
				<td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 21 */ ?></td>
			<tr>
			<tr>
				<td class="font-weight-bold">ISBN: </td>
				<td><?php echo LR\Filters::escapeHtmlText($book->isbn) /* line 25 */ ?></td>
			<tr>
<?php
		if ($book->rating >= 0) {
?>
			<tr>
				<td class="font-weight-bold">Hodnocení: </td>
				<td><?php echo LR\Filters::escapeHtmlText($book->rating) /* line 30 */ ?>%</td>
			<tr>	
<?php
		}
		if ($user->isLoggedIn() && !empty($userBook)) {
?>
			<tr> 
               <?php
			if ("1" == $actualRating) {
				$rat1 = "0";
				?> <?php
			}
			else {
				?> <?php
				$rat1 = "1";
			}
?>

               <?php
			if ("2" == $actualRating) {
				$rat2 = "0";
				?> <?php
			}
			else {
				?> <?php
				$rat2 = "2";
			}
?>

  				<td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("rate!", ['rating' => $rat1])) ?>"><i class="far fa-thumbs-up" style="color:<?php
			if ($book->userRating == 1) {
				?> green <?php
			}
			else {
				?> blue <?php
			}
?> ; font-size: 24px;"></i></a>
  				<a  href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("rate!", ['rating' => $rat2])) ?>"><i class="far fa-thumbs-down" style="color:<?php
			if ($book->userRating == 2) {
				?> red <?php
			}
			else {
				?> blue <?php
			}
?>; font-size: 24px;"></i></a></td>
  			<tr>
<?php
		}
?>
		</table>
	  </div>
     <div class = "col-12">Pokud by se pro stejný účel použil smysluplný text, bylo by těžké hodnotit pouze vzhled, aniž by se pozorovatel nechal svést ke čtení obsahu. Pokud by byl naopak použit nesmyslný, ale pravidelný text (např. opakování „asdf asdf asdf…“), oko by při posuzování vzhledu bylo vyrušováno pravidelnou strukturou textu, která se od běžného textu liší. Text lorem ipsum na první pohled připomíná běžný text, slova jsou různě dlouhá, frekvence písmen je podobná běžné řeči, interpunkce vypadá přirozeně atd.</div>
		
	</div>
</div>


<?php
	}

}
