<div class="container">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Derby Name</th>
                <th>Name</th>
                <th>Organization</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo $contact['Contact']['derby_name']; ?></td>
                    <td><?php echo $contact['Contact']['name']; ?></td>
                    <td><?php echo $contact['Organization']['name']; ?></td>
                    <td><?php echo $this->Html->link('View', array('action' => 'view', $contact['Contact']['id']), array('class' => 'btn btn-default')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>