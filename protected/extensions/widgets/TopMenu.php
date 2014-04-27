<?php

class TopMenu extends CWidget
{
	
	/*
	 * $items[type] - typ elementu
	 * $items[name] - nazwa elementu menu
	 * $items[url] - łącze, do którego prowadzi element
	 */
	public $items;
	
	public function run()
	{
		?><ul class="nav nav-pills"><?php
			foreach($this->items as $item)
			{
				?>
					<li><a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a></li>
				<?php
			}			
		?></ul><?php
	}
}