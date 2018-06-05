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
	<h1><?php echo LR\Filters::escapeHtmlText($book->name) /* line 3 */ ?></h1>
	<div class = "row">

		<div class = "col-lg-2 col-md-3 col-sm-4">
			<img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath.'/'.$book->img)) /* line 7 */ ?>" alt="<?php
		echo LR\Filters::escapeHtmlAttr($book->name) /* line 7 */ ?> přebal" height="160" width="100">
		</div>
		<div class = "col-lg-10 col-md-9 col-sm-8">
		<table>
<?php
		if ($user->isInRole('admin') == 1) {
?>
           <tr>
           <td> 
            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:edit", ['id' => $book->id])) ?>">Editovat</a>
           </td>
           <td> </td>
           </tr>
<?php
		}
?>

			<tr>
				<td class="font-weight-bold">Autor: </td>
				<td><?php echo LR\Filters::escapeHtmlText($book->author) /* line 22 */ ?></td>
			</tr>
			<tr>
				<td class="font-weight-bold">Stran: </td>
				<td><?php echo LR\Filters::escapeHtmlText($book->pages) /* line 26 */ ?></td>
			</tr>
			<tr>
				<td class="font-weight-bold">Žánr: </td>
				<td><?php echo LR\Filters::escapeHtmlText($genres) /* line 30 */ ?></td>
			</tr>
			<tr>
				<td class="font-weight-bold">ISBN: </td>
				<td><?php echo LR\Filters::escapeHtmlText($book->isbn) /* line 34 */ ?></td>
			</tr>
<?php
		if ($book->rating >= 0) {
?>
			<tr>
				<td class="font-weight-bold">Hodnocení: </td>
				<td><?php
			if (empty($book->rating)) {
				?>0%<?php
			}
			else {
				echo LR\Filters::escapeHtmlText($book->rating) /* line 39 */ ?>%<?php
			}
?></td>
			</tr>	
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
  				<a  href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("rate!", ['rating' => $rat2])) ?>"><i class="far fa-thumbs-down marLeft" style="color:<?php
			if ($book->userRating == 2) {
				?> red <?php
			}
			else {
				?> blue <?php
			}
?>; font-size: 24px;"></i></a></td>
  			    <td> </td>
  			</tr>
<?php
		}
?>
		</table>
	  </div>
     <div class = "col-12"> <?php echo LR\Filters::escapeHtmlText($book->description) /* line 53 */ ?> </div>
	</div>
<?php
		if ($user->isLoggedIn() && !empty($userBook)) {
			?>       <a onclick="return confirm('Opravdu chcete knihu odebraz ze seznamu?')" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteBookFromUser!", ['bookId' => $book->id])) ?>">Odebrat ze seznamu</a>	
<?php
		}
		elseif ($user->isLoggedIn()) {
			?> 	   <a  href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("addBookToUser!", ['bookId' => $book->id])) ?>">Přidat do seznamu</a>
<?php
		}
?>
</div>


<?php
	}

}
