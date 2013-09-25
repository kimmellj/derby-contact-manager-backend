<div class="container">

    <div class="row">
        <div class="col-md-11">
            <h2>
                <?php echo $contact['Contact']['name']; ?>
                <?php echo (!empty($contact['Contact']['derby_name']) && !empty($contact['Contact']['name'])) ? '/': ''; ?>
                <?php echo $contact['Contact']['derby_name']; ?>
            </h2>
            <h3>
                <?php $i = 0; foreach ($contact['Organization'] as $organization): ?>
                    <?php echo $this->Html->link($organization['name'], '#', array('class' => '')); ?>
                    <?php echo $i != sizeof($contact['Organization']) - 1 ? '/' : ''; ?>
                    <?php $i++; endforeach; ?>
            </h3>

            <h3>
                <?php $i = 0; foreach ($contact['Role'] as $role): ?>
                    <?php echo $role['name']; ?>
                    <?php echo $i != sizeof($contact['Role']) - 1 ? '/' : ''; ?>
                    <?php $i++; endforeach; ?>
            </h3>
        </div>
        <div class="col-md-1 text-right">
            <?php if (!empty($contact['Contact']['profile_pic'])): ?>
                <br /><br /><img src="<?php echo $contact['Contact']['profile_pic']; ?>" />
            <?php endif; ?>
        </div>
    </div>

    <?php echo $this->Html->link('Back to List', array('action' => 'index'), array('class' => 'btn btn-default pull-right')); ?>

    <dl>
        <?php if (!empty($contact['Contact']['phone'])): ?>
            <dt>Phone</dt>
            <dd><?php echo $contact['Contact']['phone']; ?></dd>
        <?php endif; ?>
        <?php if (!empty($contact['Contact']['email'])): ?>
            <dt>Email</dt>
            <dd><?php echo $contact['Contact']['email']; ?></dd>
        <?php endif; ?>
        <?php if (!empty($contact['Contact']['facebook_link'])): ?>
            <dt>Facebook Link</dt>
            <dd><?php echo $this->Html->link($contact['Contact']['facebook_link']); ?></dd>
        <?php endif; ?>
        <?php if (!empty($contact['Contact']['certification'])): ?>
            <dt>Ref Certification</dt>
            <dd><?php echo $contact['Contact']['certification']; ?></dd>
        <?php endif; ?>
        <?php if (!empty($contact['Contact']['resume'])): ?>
            <dt>Ref Resume</dt>
            <dd><?php echo $this->Html->link($contact['Contact']['resume']); ?></dd>
        <?php endif; ?>
    </dl>

</div>