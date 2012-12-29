<?php

class Memory {

    function __construct() {

        /* --------------------------------------------------------------
         * Memory information
         * -------------------------------------------------------------- */
        @preg_match_all('/^([^:]+)\:\s+(\d+)\s*(?:k[bB])?\s*/m', read('/proc/meminfo'), $matches, PREG_SET_ORDER);
        
        if ($matches) {
            foreach ($matches as $item) {

                switch (strtolower($item[1])) {
                    case 'memtotal':
                        $this->total = $item[2];
                        break;
                    case 'memfree':
                        $this->free = $item[2];
                        break;
                }
            }

            $this->used = $this->total - $this->free;
            $this->percentage = $this->used / $this->total * 100;
        }

        /* --------------------------------------------------------------
         * dmidecode
         * -------------------------------------------------------------- */
        exec('/usr/sbin/dmidecode --type 17 2> /dev/null', $dmi);
        
        if ($dmi) {
            foreach ($dmi as $item) {
                if (!strpos($item, ':'))
                    continue;

                list($key, $value) = explode(':', $item, 2);

                switch (strtolower(trim($key))) {
                    case 'type':
                        $this->type = $value;
                        break;
                    case 'manufacturer':
                        $this->type = $value;
                        break;
                    case 'speed':
                        $this->peed = $value;
                        break;
                }
            }
        }
    }

}