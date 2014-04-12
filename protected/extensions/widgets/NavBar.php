<?php

class NavBar extends CWidget
{
	public $brand = 'Integra Manager';
	
	/*
	 * $items[type] - typ elementu
	 * $items[name] - nazwa elementu menu
	 * $items[url] - łącze, do którego prowadzi element
	 */
	public $items;
	
	public function run()
	{
		?>		
			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"><?php echo $this->brand; ?></a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<?php 
								foreach($this->items as $item)
								{
									switch ($item['type'])
									{
										case 'item':
											?><li><a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a></li><?php
											break;
										case 'dropdown':
											?>
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $item['name'] ?> <b class="caret"></b></a>
												<ul class="dropdown-menu">
													<?php 
														foreach($item['items'] as $dropdownItem)
														{
															switch ($dropdownItem['type'])
															{
																case 'item':
																	?><li><a href="<?php echo $dropdownItem['url']; ?>"><?php echo $dropdownItem['name']; ?></a></li><?php
																	break;
																case 'divider':
																	?><li class="divider"></li><?php
																	break;
															}
														}														
													?>
												</ul>
											</li>
											<?php
											break;
										case 'divider':
											?><li class="divider"></li><?php
											break;
									}			
								}
							?>
						</ul>
					</div>
				</div>
			</nav>
		<?php
	}
}

?>

