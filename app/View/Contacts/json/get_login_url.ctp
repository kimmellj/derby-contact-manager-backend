<?php
if (isset($_REQUEST['callback'])) {
    print "{$_REQUEST['callback']}( ".json_encode(array('loginUrl' => $loginUrl))." );";
} else {
    print json_encode(array('loginUrl' => $loginUrl));
}