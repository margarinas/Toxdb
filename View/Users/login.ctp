<div class="users form">
<?php echo $this->Session->flash('auth',array('element'=>'failure')); ?>
<?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>
    <fieldset>
        <legend><?php echo __('Įveskite savo prisijungimo vardą ir slaptažodį'); ?></legend>
    <?php
        echo $this->Form->input('username',array('label'=>'Vartotojo vardas'));
        echo $this->Form->input('password',array('label'=>'Slaptažodis'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Prisijungti')); ?>

</div> 