<?php
if (isset($_REQUEST['callback'])) {
    print "{$_REQUEST['callback']}( ".json_encode($organizations)." );";
} else {
    print json_encode($organizations);
}