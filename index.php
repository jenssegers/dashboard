<?php

/* --------------------------------------------------------------
 * Load system
 * -------------------------------------------------------------- */
require('system.php');
$system = new System;


/* --------------------------------------------------------------
 * Get current directory
 * -------------------------------------------------------------- */
$base = rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__)), '/');
?>

<!doctype html>
<html>
<head>
    <title><?php echo $system->os->hostname; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="<?php echo $base . '/static/dark.css'; ?>">
</head>
<body onload="init()">

<div id="container">

<h1>
    <?php echo $system->os->hostname; ?>
    <small id="uptime">online for <?php echo $system->uptime->days; ?> days, <?php echo $system->uptime->hours; ?> hours, <?php echo $system->uptime->minutes; ?> minutes </small>
</h1>

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
    <script>
        function refresh() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "index.php", true);
            xhttp.send();
        }
        function init() {
            refresh()
            var int = self.setInterval(function () {
                refresh()
            }, 1000);
        }
    </script>
</body>
</html>
