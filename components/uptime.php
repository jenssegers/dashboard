<?php

class Uptime {

    function __construct() {

        /* --------------------------------------------------------------
         * System uptime
         * -------------------------------------------------------------- */
        $output = read('/proc/uptime');
        list($seconds) = explode(' ', $output);
        
        $minutes = (int) $seconds / 60;
        $seconds = $seconds % 60;
        $hours = (int) $minutes / 60;
        $minutes = $minutes % 60;
        $days = (int) $hours / 24;
        $hours = $hours % 24;
        
        $this->days = floor($days);
        $this->hours = floor($hours);
        $this->minutes = floor($minutes);
        $this->seconds = floor($seconds);
    }

}