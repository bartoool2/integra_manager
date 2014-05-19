<?php

class StatusBar extends CWidget
{       
        public function run()
        {
		$zones = Zone::model()->findAll();
                ?><div id="status-bar" class="layout-row well well-sm">
                        <div style="width: 100%">
				<?php
					foreach($zones as $zone)
					{
						?>
						<div class="status-cell desktop-only">
							<h4 style="margin: 0 0 0 20%"><span class="label label-<?php echo $zone->statusClass; ?>" style="display: block; width: 60%; height: 20px"><?php echo $zone->number.': '.$zone->name; ?></span></h4>
						</div>
						<div class="status-cell mobile-only">
							<h4 style="margin: 0 0 0 20%"><span class="label label-<?php echo $zone->statusClass; ?>" style="display: block; width: 60%; height: 20px"><?php echo $zone->number; ?></span></h4>
						</div>
						<?php                                                        
					}
				?>
                        </div>
                </div><?php
        }
}
?>
