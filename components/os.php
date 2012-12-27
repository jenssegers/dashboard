<?php

class OS {

    function __construct() {

    	/* --------------------------------------------------------------
         * Basic OS information
         * -------------------------------------------------------------- */
        $this->hostname = gethostname();
        $this->os = PHP_OS . php_uname('r');
        $this->name = $_SERVER['SERVER_NAME'];
        $this->php = phpversion();
    }

}