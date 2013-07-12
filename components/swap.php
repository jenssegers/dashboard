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

            if ($this->total)
            {
                $this->used = $this->total - $this->free;
                $this->percentage = $this->used / $this->total * 100;
            }
            // there is no swap
            else
            {
                $this->used = 0;
                $this->percentage = 0;
            }
            
        }
    }

}