<?php
if (isset($_REQUEST['callback'])) {
    print "{$_REQUEST['callback']}( ".json_encode($contacts)." );";
} else {
    print json_encode($contacts);
}