<?php

class StatusBar extends CWidget
{
        public $items = array();
        
        public function run()
        {
                ?><div id="status-bar" class="layout-row well well-sm">
                        <div style="display: table; width: 100%; table-layout: fixed;">
                                <div style="display: table-row">
                                        <?php
                                                foreach($this->items as $item)
                                                {
                                                        $status = Status::getStatus($item);
                                                        ?>
                                                        <div style="display: table-cell" class="status-cell">
                                                                <h4 style="margin: 0"><small class="desktop-only-inline"><?php echo $status->name; ?></small><img class="status-image" src="<?php echo $status->graphic; ?>"/></h4>
                                                        </div>
                                                        <?php                                                        
                                                }
                                        ?>
                                </div>
                        </div>
                </div><?php
        }
}
?>
