<?php
include ('connect.php');
include ('functions.php');

if (isset($_POST['api'])) {
    
    $api_method = $_POST['api'];    
    
    if ($api_method == 'get_catalog') get_catalog($link, $_POST['category'], $_POST['sort'], $_POST['limit'], $_POST['page']);
    if ($api_method == 'get_categories') get_categories($link);
    
    
}
?>