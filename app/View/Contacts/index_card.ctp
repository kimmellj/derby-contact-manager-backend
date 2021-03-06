<div class="container">
    
    <?php echo $this->Session->flash(); ?>
    
    <?php if (!$contactVerified): ?>
        <div class="alert alert-warning">
            Bummer, it looks like your not verified yet. This means you will only be able to view Derby Names, Organizations and Roles. <br />
            Getting verified is easy though! An <strong>Authorized</strong> member from your organization can login and verify you. <br /><br />
            The following people are <strong>Authorized</strong> to verify you:<br />
            <ul>
                <?php $ownerFound = false; foreach ($canAuthorizeCurrentContact as $contact): ?>
                    <?php if ($contact['Contact']['email'] == 'kimmellj@gmail.com') { $ownerFound = true; } ?>
                    <li>
                            <?php echo $contact['Contact']['derby_name']; ?>
                            <?php echo (!empty($contact['Contact']['name']) && !empty($contact['Contact']['derby_name'])) ? '/':''; ?>
                            <?php echo $contact['Contact']['name']; ?> -
                            <?php echo $contact['Contact']['email']; ?>
                    </li>
                <?php endforeach; ?>
                <?php if (!$ownerFound): ?>
                    <li>(Site Owner) Predicament / Jamie Kimmell - kimmellj@gmail.com</li>
                <?php endif; ?>
            </ul>
            <br />
            Please get in touch with one of your Authorized contacts and have them verify you. Once verified you will be able to view all details about a contact.
        </div>
    <?php endif; ?>

    <ul class="nav nav-tabs">
        <li class="<?php echo (empty($currentRoleId) || $currentRoleId == '%') ? 'active':''; ?>"><?php echo $this->Html->link('All', array('role_id' => false)); ?></li>
        <?php foreach ($roles as $roleId => $role): ?>
            <li class="<?php echo (!empty($currentRoleId) && $currentRoleId == $roleId) ? 'active':''; ?>"><?php echo $this->Html->link($role, array('role_id' => $roleId)); ?></li>
        <?php endforeach; ?>
    </ul>

    <div class="clearfix"></div>
    <br />
    <div class="row">
        <div class="col-md-2 col-md-push-10">
            <?php echo $this->Html->link('List View', array('action' => 'index', 'list'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <ul class="pagination">
                <?php
                echo '<li>'.$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')).'</li>';
                echo $this->Paginator->numbers(array('currentTag' => 'span', 'tag' => 'li', 'separator' => ''));
                echo '<li>'.$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')).'</li>';
                ?>
            </ul>
            <p>
                <?php
                echo $this->Paginator->counter(
                    'Page {:page} of {:pages}, showing {:current} records out of
                     {:count} total, starting on record {:start}, ending on {:end}'
                );
                ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 col-md-offset-2 col-sm-12">
            <?php foreach ($contacts as $contact): ?>
                <div class="contact panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $contact['Contact']['derby_name']; ?>
                            <?php echo (!empty($contact['Contact']['name']) && !empty($contact['Contact']['derby_name'])) ? '/':''; ?>
                            <?php echo $contact['Contact']['name']; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?php if (!empty($contact['Contact']['profile_pic'])): ?>
                                    <img src="<?php echo $contact['Contact']['profile_pic']; ?>" height="50" width="50" />
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <div class="organizatons">
                                    <strong>Organizations: </strong>
                                    <?php $showAuthorizeButton = false; $i = 0; foreach ($contact['Organization'] as $organization): ?>
                                        <?php echo $this->Html->link($organization['name'], '#', array('class' => '')); ?>
                                        <?php echo $i != sizeof($contact['Organization']) - 1 ? '/' : ''; ?>
                                        <?php if(in_array($organization['id'], $contactAuthorizedToVerify)) { $showAuthorizeButton = true; } ?>
                                        <?php $i++; endforeach; ?>
                                </div>
                                <hr>
                                <div class="roles">
                                    <strong>Roles: </strong>
                                    <?php $i = 0; foreach ($contact['Role'] as $role): ?>
                                        <?php echo $role['name']; ?>
                                        <?php echo $i != sizeof($contact['Role']) - 1 ? '/' : ''; ?>
                                        <?php $i++; endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php echo $this->Html->link('View Full Details', array('action' => 'view', $contact['Contact']['id']), array('class' => 'btn btn-default')); ?>
                        
                        <?php if ($contact['Contact']['verified']): ?>
                            <?php echo $this->Html->link('This contact has been verified', '#', array('class' => 'btn btn-default disabled')); ?>
                        <?php else: ?>
                            <?php if ($showAuthorizeButton): ?>
                                <?php echo $this->Html->link('Verify this user', array('action' => 'verify', $contact['Contact']['id']), array('class' => 'btn btn-primary')); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 col-md-offset-2 col-sm-12">
            <ul class="pagination">
                <?php
                echo '<li>'.$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')).'</li>';
                echo $this->Paginator->numbers(array('currentTag' => 'span', 'tag' => 'li', 'separator' => ''));
                echo '<li>'.$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')).'</li>';
                ?>
            </ul>
        </div>
    </div>

</div>