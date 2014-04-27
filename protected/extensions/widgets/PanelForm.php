<?php

class PanelForm extends CWidget
{
        public $id = 'Id';
        public $cssClass = 'left';
        public $title = 'Panel title';
        public $buttonLabel = 'Submit';
        
        public function run()
        {
                ?><div class="panel panel-default code-panel <?php echo $this->cssClass; ?>">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?php echo $this->title; ?></h3>
                        </div>
                        <div class="panel-body">
                                <input name="<?php echo $this->id.'[code]' ?>" type="number" class="form-control panel-input" placeholder="Podaj kod"/>
                                <button value="1" name="<?php echo $this->id.'[submit]' ?>" class="btn btn-primary panel-button" type="submit"><?php echo $this->buttonLabel; ?></button>
                        </div>
                </div><?php
        }
}
?>
