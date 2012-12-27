<?php

/* --------------------------------------------------------------
 * Load system
 * -------------------------------------------------------------- */
require('system.php');


/* --------------------------------------------------------------
 * Get an APC cached version of the system object if available
 * -------------------------------------------------------------- */
if(function_exists('apc_store') && !apc_exists('dashboard')) {
    $system = new System;
    apc_store('dashboard', $system, 10);
} else {
    $system = apc_fetch('dashboard');
}

?>

<!doctype html>
<html>
<head>
	<title>sandy.jenssegers.be</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" href="/dashboard/static/dark.css">
</head>
<body>

<div id="container">

<h1><?php echo $system->general->name; ?></h1>

<?php

/* --------------------------------------------------------------
 * Show widgets
 * -------------------------------------------------------------- */
$directory = dirname(__FILE__) . '/widgets';
$widgets = scandir($directory,  SCANDIR_SORT_ASCENDING);

foreach ($widgets as $widget) {
	if ($widget != '.' && $widget != '..') {
		include($directory . '/' . $widget);
	}
}

?>

</div>

</body>
</html>