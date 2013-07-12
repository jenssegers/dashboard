<?php

class Cpu {

    function __construct() {

        /* --------------------------------------------------------------
         * CPU load
         * -------------------------------------------------------------- */
        $parts = explode(" ", read('/proc/loadavg'));

        if ($parts) {
            $this->load = $parts[0];
            $this->load5 = $parts[1];
            $this->load15 = $parts[2];
        }


        /* --------------------------------------------------------------
         * CPU information
         * -------------------------------------------------------------- */
        $processors = preg_split('/\s?\n\s?\n/', read('/proc/cpuinfo'));
        
        if ($processors) {
            // only using first cpu for information
            $processor = reset($processors);
            $lines = explode("\n", $processor);

            foreach ($lines as $line) {
                list($key, $value) = explode(':', $line, 2);

                switch (strtolower(trim($key))) {
                    case 'processor':
                    case 'model name':
                        $this->name = $value;
                        break;
                    case 'clock':
                    case 'cpu mhz':
                        $this->frequency = $value;
                        break;
                    case 'bogomips':
                        if (!isset($this->frequency))
                            $this->frequency = $value;
                        break;
                }

            }

            $this->count = count($processors);
        }


        /* --------------------------------------------------------------
         * Raspberry Pi Temperature
         * -------------------------------------------------------------- */
        $temp = read('/sys/class/thermal/thermal_zone0/temp');
        
        if ($temp) {
            $this->temp = $temp / 1000;
        }

    }

}