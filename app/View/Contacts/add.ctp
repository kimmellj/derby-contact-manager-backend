<div class="container">
    <h2>Add a Contact</h2>

    <?php echo $this->Form->create('Contact', array(
        'type' => 'file',
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
                        <div class="col-md-12">
                            <input type="file" name="data[Contact][profile_pic]">
                            <p class="help-block">Or you can upload your own picture here</p>
                        </div>
                    </div>
                </div>
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