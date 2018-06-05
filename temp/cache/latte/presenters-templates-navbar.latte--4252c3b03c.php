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


<nav class="navbar navbar-expand-md navbar-light bg-light marBot">
  <span class="navbar-brand mouseH">BookHero</span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarToggler">
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
		if ($user->isInRole('admin') == 1) {
?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Správa<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:list")) ?>">Seznam uživatelů</a></li>
                <li><a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:add")) ?>">Přidání knih</a> </li>
                <li><a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Book:addGenre")) ?>">Správa žánrů</a> </li>
              </ul>
            </li>
<?php
		}
?>
        </ul>

        <ul class="nav navbar-nav navbar-right">
           <li class="nav-item">
            <form class="form-inline my-2 my-lg-0" method="GET" id="searchForm">
                <input class="form-control mr-sm-2" id="findBook" type="search" placeholder="Název knihy" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" id="searchBtn">Hledej  </button>
            </form>
          </li>
           
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
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><?php echo LR\Filters::escapeHtmlText($user->getIdentity()->email) /* line 49 */ ?><span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:changePassword")) ?>">Změna hesla</a></li>
              </ul>
            </li>
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
