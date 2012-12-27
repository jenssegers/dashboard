<?php

class Swap {

	function __construct() {

		@preg_match_all('/^([^:]+)\:\s+(\d+)\s*(?:k[bB])?\s*/m', read('/proc/meminfo'), $matches, PREG_SET_ORDER);
        
        $memory = array();
        foreach ($matches as $item) {
            $memory[$item[1]] = $item[2];
        }
        
        $this->total = $memory['SwapTotal'];
        $this->free = $memory['SwapFree'];
        $this->used = $this->total - $this->free;
        $this->percentage = $this->used / $this->total;
        
        unset($memory);
	}

}