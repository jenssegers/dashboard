<?php

class Processes {

    function __construct() {

        $processes = (array) @glob('/proc/*/status', GLOB_NOSORT);
        $this->count = count($processes);

        unset($processes);
    }

}