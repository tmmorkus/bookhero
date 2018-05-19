<?php
// source: C:\xampp\htdocs\bookhero\app\presenters\templates\navbar.latte

use Latte\Runtime as LR;

class Template4252c3b03c extends Latte\Runtime\Template
{
	public $blocks = [
		'navbar' => 'blockNavbar',
	];

	public $blockTypes = [
		'navbar' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('navbar', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockNavbar($_args)
	{
		extract($_args);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">BookHero</a>
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li <?php if ($_tmp = array_filter(['nav-item', $presenter->isLinkCurrent('Book:list') ? 'active' : NULL])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>>
                <a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:list", ['orderBy'=>'name'])) ?>">Seznam Knih</a>
            </li>
<?php
		if ($user->isLoggedIn()) {
			?>            <li <?php if ($_tmp = array_filter(['nav-item', $presenter->isLinkCurrent('Book:userbooks') ? 'active' : NULL])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>>
                <a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:userBooks")) ?>">Uživatelský seznam</a>
            </li>
<?php
		}
?>
        </ul>
    </div>

    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
<?php
		if (!$user->isLoggedIn()) {
?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:login")) ?>">Přihlásit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:register")) ?>">Registrovat</a>
            </li>
<?php
		}
		else {
?>
             <li class="nav-item">
                <a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:logout")) ?>">Odhlásit</a>
            </li>
<?php
		}
?>
        </ul>
    </div>
</nav><?php
	}

}
