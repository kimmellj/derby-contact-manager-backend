<?php
if (isset($_REQUEST['callback'])) {
    print "{$_REQUEST['callback']}( ".json_encode($userProfile)." );";
} else {
    print json_encode($userProfile);
}