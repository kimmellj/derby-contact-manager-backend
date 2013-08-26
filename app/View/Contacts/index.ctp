<table>
    <thead>
        <tr>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?php echo $contact['Contact']['name']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>