<?php

class Disks {

    function __construct() {

        /* --------------------------------------------------------------
         * Get all disks
         * -------------------------------------------------------------- */
        $regular = (array) @glob('/sys/block/*/device/model', GLOB_NOSORT);
        $virtual = (array) @glob('/sys/block/xvd*', GLOB_NOSORT);

        $paths = array();
        foreach ($regular as $path) {
            $paths[] = dirname(dirname($path));
        }
        foreach ($virtual as $path) {
            $paths[] = $path;
        }


        /* --------------------------------------------------------------
         * Get partitions
         * -------------------------------------------------------------- */
        $partitions = explode("\n", read('/proc/partitions'));
        $partitions = array_slice($partitions, 2);
        foreach ($partitions as &$partition) {
            $partition = preg_split('/\s+/', $partition);
        }

        /* --------------------------------------------------------------
         * Disk information
         * -------------------------------------------------------------- */
        foreach ($paths as $path) {
            $parts = explode('/', $path);
            $drive = end($parts);
            
            if (preg_match('/^(\d+)\s+\d+\s+\d+\s+\d+\s+(\d+)\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+$/', read($path . '/stat'), $matches) !== 1) {
                $reads = 0;
                $writes = 0;
            } else {
                list(, $reads, $writes) = $matches;
            }
            
            $this->{$drive} = new stdClass;
            $this->{$drive}->name = read($path . '/device/model');
            $this->{$drive}->size = read($path . '/size', 0) * 512;
            $this->{$drive}->reads = $reads;
            $this->{$drive}->writes = $writes;

            if (!$this->{$drive}->name)
                $this->{$drive}->name = 'Virtual ' . $drive;
            

            /* --------------------------------------------------------------
             * Disk usage
             * -------------------------------------------------------------- */
            foreach ($partitions as $partition) {
                if (strpos($partition[4], $drive) && is_numeric(str_replace($drive, '', $partition[4]))) {
                    $df = exec('df /dev/' . $partition[4]);

                    if (@preg_match('#\s+(\d+)\s+(\d+)\s+(\d+)#', $df, $matches)) {
                        $this->{$drive}->used += $matches[2] * 1024;
                        $this->{$drive}->percentage = $this->{$drive}->used / $this->{$drive}->size * 100;
                    }
                }
            }

            if (!isset($this->{$drive}->used)) {
                $df = exec('df /dev/' . $drive . '1');

                if (@preg_match('#\s+(\d+)\s+(\d+)\s+(\d+)#', $df, $matches)) {
                    $this->{$drive}->used += $matches[2] * 1024;
                    $this->{$drive}->percentage = $this->{$drive}->used / $this->{$drive}->size * 100;
                }
            }
            

            /* --------------------------------------------------------------
             * hddtemp
             * -------------------------------------------------------------- */
            exec('hddtemp /dev/'.$drive . ' 2> /dev/null', $hddtemp);
            
            if ($hddtemp) {
                $hddtemp = $hddtemp[0];
                @preg_match('#:\s+([\d]+)#', $hddtemp, $matches);
                $disks[$drive]->temp = $matches[1];
            }
        }

        unset($disks);
    }

}