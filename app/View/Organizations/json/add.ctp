<?php
if (isset($_REQUEST['callback'])) {
    print "{$_REQUEST['callback']}( ".json_encode($response)." );";
} else {
    print json_encode($response);
}