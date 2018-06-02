<?php
// source: C:\xampp\htdocs\bookhero\app\presenters/templates/User/list.latte

use Latte\Runtime as LR;

class Template35da89681f extends Latte\Runtime\Template
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
		if (isset($this->params['userS'])) trigger_error('Variable $userS overwritten in foreach on line 17');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
   
 
<?php
		if (!empty($users)) {
?>
    
    
  <table class="table table-hover">
  <thead>
     <tr>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:List", ['orderBy'=>'id', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">ID</a></th>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:List", ['orderBy'=>'email', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">email</a></th>
      <th><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:List", ['orderBy'=>'role', 'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">role</a></th>
      <th> </th>
    </tr>
  </thead>
   <tbody>
<?php
			$iterations = 0;
			foreach ($users as $userS) {
?>
     <tr>
      <td><?php echo LR\Filters::escapeHtmlText($userS->id) /* line 19 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($userS->email) /* line 20 */ ?></td>
      <td><?php echo LR\Filters::escapeHtmlText($userS->role) /* line 21 */ ?></td>
      <td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("admin!", ['id' => $userS->id])) ?>">Změnit práva</a></td>
      <td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("delete!", ['id' => $userS->id])) ?>">Odstranit uživatele</a></td>

     </tr>
<?php
				$iterations++;
			}
?>
    </tbody>  
    </table>
    <div class="pagination">
<?php
			if (!$paginator->isFirst()) {
				?>        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("list", [1, 'orderBy'=>$orderPrev,'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">První</a>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("list", ['page' => $paginator->page-1, 'orderBy'=>$orderPrev,'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Předchozí</a>
        &nbsp;|&nbsp;
<?php
			}
?>

    Stránka <?php echo LR\Filters::escapeHtmlText($paginator->page) /* line 37 */ ?> z <?php echo LR\Filters::escapeHtmlText($paginator->pageCount) /* line 37 */ ?>

<?php
			if (!$paginator->isLast()) {
?>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("list", ['page' => $paginator->page+1, 'orderBy'=>$orderPrev,'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Další</a>
        &nbsp;|&nbsp;
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("list", ['page' => $paginator->pageCount,'orderBy'=>$orderPrev,'order'=>$order, 'orderPrev'=>$orderPrev])) ?>">Poslední</a>
<?php
			}
?>
</div>
<?php
		}
		else {
?>
    <p>V seznamu nejsou žádní uživatelé</p>
<?php
		}
?>

<?php
	}

}
