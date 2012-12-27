<?php

class General {

    function __construct() {

        $this->hostname = gethostname();
        $this->os = PHP_OS . php_uname('r');
        $this->name = $_SERVER['SERVER_NAME'];
    }

}