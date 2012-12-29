<?php

class Swap {

    function __construct() {

        /* --------------------------------------------------------------
         * Swap information
         * -------------------------------------------------------------- */
        @preg_match_all('/^([^:]+)\:\s+(\d+)\s*(?:k[bB])?\s*/m', read('/proc/meminfo'), $matches, PREG_SET_ORDER);
        
        if ($matches) {
            foreach ($matches as $item) {

                switch (strtolower($item[1])) {
                    case 'swaptotal':
                        $this->total = $item[2];
                        break;
                    case 'swapfree':
                        $this->free = $item[2];
                        break;
                }
            }

            $this->used = $this->total - $this->free;
            $this->percentage = $this->used / $this->total * 100;
        }
    }

}