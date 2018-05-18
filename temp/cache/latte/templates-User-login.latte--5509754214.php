<?php
// source: C:\xampp\htdocs\bookhero\app\presenters/templates/User/login.latte

use Latte\Runtime as LR;

class Template5509754214 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'title' => 'blockTitle',
	];

	public $blockTypes = [
		'content' => 'html',
		'title' => 'html',
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
		$this->renderBlock('title', get_defined_vars());
?>

<?php
		/* line 4 */ $_tmp = $this->global->uiControl->getComponent("loginForm");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(null, false);
		$_tmp->render();
?>

  <p>Nemáte zatím svůj účet? <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:register")) ?>">Zaregistrujte se...</a></p><?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?>  <h1>Přihlásit se</h1>
<?php
	}

}
