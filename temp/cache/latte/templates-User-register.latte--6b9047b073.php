<?php
// source: C:\xampp\htdocs\bookhero\app\presenters/templates/User/register.latte

use Latte\Runtime as LR;

class Template6b9047b073 extends Latte\Runtime\Template
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
		/* line 4 */ $_tmp = $this->global->uiControl->getComponent("registrationForm");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(null, false);
		$_tmp->render();
?>

  <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("fbLogin-open!")) ?>"><img src="<?php
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath.'/images/icons/fb_login.png')) /* line 6 */ ?>" alt="Facebook login" height="50" width="170"></a> 

  <p class="marToop">Máte už svůj účet? <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:login")) ?>">Přihlašte se...</a></p><?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?>  <h1>Zaregistrovat se</h1>
<?php
	}

}
