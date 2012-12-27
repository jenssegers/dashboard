<?php

class Memory {

    function __construct() {

        @preg_match_all('/^([^:]+)\:\s+(\d+)\s*(?:k[bB])?\s*/m', read('/proc/meminfo'), $matches, PREG_SET_ORDER);
        
        if ($matches) {
            $memory = array();
            foreach ($matches as $item) {
                $memory[$item[1]] = $item[2];
            }
            
            $this->total = $memory['MemTotal'];
            $this->free = $memory['MemFree'];
            $this->used = $memory['Active'];
            $this->percentage = $this->used / $this->total * 100;
        }

        /* --------------------------------------------------------------
         * dmidecode
         * -------------------------------------------------------------- */
        exec('/usr/sbin/dmidecode --type 17', $dmi);
        
        if ($dmi) {
            $memory = array();
            foreach ($dmi as $item) {
                $parts = explode(':', $item);
                if(count($parts) == 2) {
                    list($key, $value) = explode(':', $item);
                    $memory[trim($key)] = trim($value);
                }
            }
            
            $this->type = isset($memory['Type']) ? $memory['Type'] : '';
            $this->brand = isset($memory['Manufacturer']) ? $memory['Manufacturer'] : 'Memory';
            $this->speed = isset($memory['Speed']) ? $memory['Speed'] : '';
        }
        
        unset($memory);
    }

}