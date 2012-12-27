<?php

class Cpu {

	function __construct() {

		$parts = explode(" ", read('/proc/loadavg'));

		if ($parts) {
	        $this->load = $parts[0];
	        $this->load5 = $parts[1];
	        $this->load15 = $parts[2];
    	}

    	$lines = explode("\n", read('/proc/cpuinfo'));
        
        $cpus = array();
        $current_cpu = 0;
        foreach ($lines as $line) {
            if ($line == '') {
                $current_cpu++;
            }
            
            $m = explode(':', $line, 2);
            if (count($m) == 2) {
                $cpus[$current_cpu][trim($m[0])] = trim($m[1]);
            }
        }

        $this->name = $cpus[0]['model name'];
        $this->frequency = $cpus[0]['cpu MHz'];
        
        unset($cpus);

	}

}