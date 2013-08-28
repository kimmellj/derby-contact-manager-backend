<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <ul class="list-group contacts">
                <?php foreach ($contacts as $contact): ?>
                    <li class="list-group-item" data-id="<?php echo $contact['Contact']['username']; ?>">
                        <div class="row">
                            <div class="col-md-2"><img src="<?php echo $contact['Contact']['profile_pic']; ?>" width="50" height="50" alt=""/></div>
                            <div class="col-md-8">
                                <?php echo $contact['Contact']['derby_name']; ?>
                                <?php if (!empty($contact['Contact']['derby_name']) && !empty($contact['Contact']['name'])): ?>
                                    /
                                <?php endif; ?>
                                <?php echo $contact['Contact']['name']; ?> <br />
                                <?php echo $contact['Organization']['name']; ?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $contact['Role']['name']; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $("li").on("click", function(){
            document.location = '<?php echo Router::url("/contacts/view"); ?>/'+$(this).attr("data-id");
        });
    });
</script>