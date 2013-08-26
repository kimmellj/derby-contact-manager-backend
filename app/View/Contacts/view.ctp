<div class="container">
    <h2>
        <?php echo $contact['Contact']['name']; ?>
        <?php echo (!empty($contact['Contact']['derby_name']) && !empty($contact['Contact']['namem'])) ? '/': ''; ?>
        <?php echo $contact['Contact']['derby_name']; ?>
    </h2>
    <h3>
        <?php if (!empty($contact['Contact']['organization_id'])): ?>
            <?php echo $contact['Organization']['name']; ?>
        <?php else: ?>
            Not Affiliated
        <?php endif; ?>
    </h3>

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
    </dl>

</div>