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

        /* --------------------------------------------------------------
         * Get real remote ip
         * -------------------------------------------------------------- */
        $ip = @file_get_contents('http://checkip.dyndns.org');

        if ($ip) {
            preg_match('/Current IP Address: ([0-9a-f:\.]+)/', $ip, $matches);
            $this->ip = $matches[1];
        }
    }

}
