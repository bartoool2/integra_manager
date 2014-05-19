<?php

class ZBreadCrumb extends CWidget
{
	public $id;
	
	public $links = array();
	
	public function run()
	{
		if (sizeof($this->links) > 0)
		{
			?>

			<ul class="breadcrumb">

			<?php

			for ($i = 0; $i < sizeof($this->links); $i++)
			{
				$link = $this->links[$i];

				$link['url'] = isset($link['url']) ? $link['url'] : 'javascript: void(0);';

				if ($i == sizeof($this->links) - 1)
				{
					?>
					<li class="active"><?php echo $link['label']; ?></li>
					<?php
				}
				else
				{
					?>
					<li><a href="<?php echo $link['url']; ?>"><?php echo $link['label']; ?></a> <span class="divider">/</span></li>
					<?php
				}
			}

			?>

			</ul>

			<?php
		}
	}
}
?>