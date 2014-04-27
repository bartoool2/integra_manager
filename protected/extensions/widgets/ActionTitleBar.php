<?php

class ActionTitleBar extends CWidget
{
        public $title = 'Page title';
        public $items = array();
        
        public function run()
        {
                ?><div class="action-title-bar">                        
                        <div class="button-bar">
                        <?php 
                                foreach($this->items as $item)
                                {
                                        echo '<a href="'.$item['url'].'"><button class="'.$item['class'].' button-bar-item">'.$item['label'].'</button></a>';
                                }
                        ?>
                        </div>
                        <div class="action-title">
                                <h1><small><?php echo $this->title; ?></small></h1>
                        </div>
                </div><?php
        }
}
?>
