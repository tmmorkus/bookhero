<?php
// source: C:\xampp\htdocs\bookhero\app\presenters/templates/Book/addGenre.latte

use Latte\Runtime as LR;

class Templateb966b58105 extends Latte\Runtime\Template
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
		if (isset($this->params['genre'])) trigger_error('Variable $genre overwritten in foreach on line 12');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<h1>Správa žánrů</h1>
<?php
		if (!empty($genres)) {
?>
  <table class="table table-hover">
  <thead>
     <tr>
      <th>Název</th>
      <th> </th>
    </tr>
  </thead>
   <tbody>
<?php
			$iterations = 0;
			foreach ($genres as $genre) {
?>
     <tr>
      <td><?php echo LR\Filters::escapeHtmlText($genre->name) /* line 14 */ ?></a></td>
      <td>
          <a onclick="return confirm('Opravdu chcete žánr odebrat?')" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteGenre!", ['genreId' => $genre->id])) ?>">Odebrat</a>
      </td>
     </tr>
<?php
				$iterations++;
			}
?>
    </tbody>  
    </table>
<?php
		}
?>
 <h2>Přidat žánr</h2>
<?php
		/* line 24 */ $_tmp = $this->global->uiControl->getComponent("genreAddForm");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(null, false);
		$_tmp->render();
		
	}

}
