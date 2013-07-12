<?php

class Processes {

    function __construct() {

        /* --------------------------------------------------------------
         * Process count
         * -------------------------------------------------------------- */
        $processes = (array) @glob('/proc/*/status', GLOB_NOSORT);
        $this->count = count($processes);

    }

}