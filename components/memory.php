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
                    case 'cached':
                        $this->cached = $item[2];
                        break;
                    case 'buffers':
                        $this->buffers = $item[2];
                        break;
                }
            }

            $this->used = $this->total - $this->free - $this->cached - $this->buffers;
            $this->percentage = (1 - ($this->free / $this->total)) * 100;
        }

        /* --------------------------------------------------------------
         * Get (better?) used memory from 'free -m'
         * -------------------------------------------------------------- */
        /*exec('free -k', $free);

        if ($free) {
            $free = preg_split('#\s+#', $free[2]);

            $this->used = $free[2];
            $this->free = $free[3];
        }*/

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