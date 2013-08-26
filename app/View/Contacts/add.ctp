<div class="container">
    <h2>Add a Contact</h2>

    <?php echo $this->Form->create('Contact', array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'div' => 'form-group',
            'label' => array('class' => 'control-label'),
            'class' => 'form-control'
        )
    )); ?>
        <?php echo $this->Form->hidden('facebook_id'); ?>

        <div class="row">
            <div class="col-md-5">
                <?php echo $this->Form->input('username'); ?>
                <?php echo $this->Form->input('name'); ?>
                <?php echo $this->Form->input('email'); ?>
                <?php echo $this->Form->input('phone'); ?>
                <?php echo $this->Form->input('facebook_link'); ?>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <?php echo $this->Form->input('derby_name'); ?>
                <?php echo $this->Form->input('organization_id'); ?>
                <?php echo $this->Form->input('role_id'); ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right">Add Contact</button>
                </div>
            </div>
        </div>
    </form>
</div>