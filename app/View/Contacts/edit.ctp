<?php echo $this->Html->css('chosen'); ?>
<?php echo $this->Html->script('chosen.jquery'); ?>
<div class="container">
    <h2>Update your Profile</h2>

    <?php echo $this->Form->create('Contact', array(
        'type' => 'file',
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'div' => 'form-group',
            'label' => array('class' => 'control-label'),
            'class' => 'form-control'
        )
    )); ?>
        <div class="row">
            <div class="col-md-5">
                <?php echo $this->Form->input('username'); ?>
                <?php echo $this->Form->input('name'); ?>
                <?php echo $this->Form->input('email'); ?>
                <?php echo $this->Form->input('phone'); ?>
                <?php echo $this->Form->input('facebook_link'); ?>
                <?php echo $this->Form->input('certification'); ?>
                <?php echo $this->Form->input('resume'); ?>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">Profile Picture</label>
                    <div class="row">
                        <div class="col-md-2"><img src="<?php echo $fbUser['picture']['data']['url']; ?>" alt=""/></div>
                        <div class="col-md-10">
                            <div class="checkbox">
                                <label for="">
                                    <?php echo $this->Form->checkbox('use_facebook_pic'); ?>
                                    Use you Facebook Profile Picture
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2"><img src="<?php echo $this->request->data['Contact']['profile_pic']; ?>" alt="" width="50" height="50" /></div>
                        <div class="col-md-10">
                            <input type="file" name="data[Contact][profile_pic]">
                            <p class="help-block">Or you can upload your own picture here</p>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->input('derby_name'); ?>
                <?php echo $this->Form->input('Organization', array('data-placeholder' => 'Which organization(s) do you belong to?')); ?>
                <?php echo $this->Form->input('other_organization'); ?>
                <?php echo $this->Form->input('Role', array('data-placeholder' => 'What all roles are  you part of?')); ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
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