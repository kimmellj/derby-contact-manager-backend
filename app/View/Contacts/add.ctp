<?php echo $this->Html->css('chosen'); ?>
<?php echo $this->Html->script('chosen.jquery'); ?>
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
<!--                <div class="form-group">-->
<!--                    <label for="">Use Profile Picture</label>-->
<!--                    <div class="form-control">-->
<!--                        --><?php //echo $this->Form->checkbox('use_facebook_pic'); ?>
<!--                    </div>-->
<!--                </div>-->
                <?php echo $this->Form->input('derby_name'); ?>
                <?php echo $this->Form->input('Organization', array('data-placeholder' => 'Which organization(s) do you belong to?')); ?>
                <?php echo $this->Form->input('other_organization'); ?>
                <?php echo $this->Form->input('Role', array('data-placeholder' => 'What all roles are  you part of?')); ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right">Add Contact</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function(){
       $("#RoleRole").chosen();
       $("#OrganizationOrganization").chosen();
    });
</script>