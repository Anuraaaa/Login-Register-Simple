<?php
// Get the URL parameter
$url = isset($_GET['url']) ? $_GET['url'] : 'dashboard';

// Split the URL into segments
$segments = explode('/', $url);

// Determine the module, controller, and action
$file = isset($segments[0]) ? $segments[0] : 'default';

// Include the appropriate controller file
include($file . '.php');
?>