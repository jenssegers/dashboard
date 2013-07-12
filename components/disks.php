<?php

class Disks {

    function __construct() {

        /* --------------------------------------------------------------
         * Get all disks
         * -------------------------------------------------------------- */
        $paths = (array) @glob('/sys/block/*/device', GLOB_NOSORT);

        $drives = array();
        foreach ($paths as $path) {
            $parts = explode('/', $path);
            array_pop($parts); // throw away last part
            $drives[end($parts)] = implode('/', $parts);
        }


        /* --------------------------------------------------------------
         * Get partitions
         * -------------------------------------------------------------- */
        $partitions = array_slice(explode("\n", read('/proc/partitions')), 2);
        foreach ($partitions as $k=>$partition) {
            $partitions[$k] = preg_split('/\s+/', $partition);
        }


        /* --------------------------------------------------------------
         * Disk information
         * -------------------------------------------------------------- */
        foreach ($drives as $drive => $path) {
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
            $this->{$drive}->used = 0;
            $this->{$drive}->percentage = 0;

            if (!$this->{$drive}->name) {
                $type = read($path . '/device/type');

                if ($type)
                    $this->{$drive}->name = $type . ' ' . $drive;
                else
                    $this->{$drive}->name = 'Virtual ' . $drive;
            }
            

            /* --------------------------------------------------------------
             * Disk usage
             * -------------------------------------------------------------- */
            foreach ($partitions as $partition)
            {
                $part = $partition[4];

                if (strpos($part, $drive) !== FALSE)
                {
                    $df = array(); exec('df /dev/' . $part, $df);

                    if (@preg_match('#\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)%\s+(.*)#', $df[1], $matches))
                    {
                        $this->{$drive}->used += $matches[2] * 1024;
                        $this->{$drive}->percentage = $this->{$drive}->used / $this->{$drive}->size * 100;

                        # virtual drive fix
                        if ($matches[2] == 0 && $part == 'vda')
                        {
                            # assume main drive
                            $df = array(); exec('df /', $df);

                            if (@preg_match('#\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)%\s+(.*)#', $df[1], $matches))
                            {
                                $this->{$drive}->used += $matches[2] * 1024;
                                $this->{$drive}->percentage = $this->{$drive}->used / $this->{$drive}->size * 100;
                            }
                        }
                    }
                }
            }
            

            /* --------------------------------------------------------------
             * hddtemp
             * -------------------------------------------------------------- */
            $hddtemp = array(); exec('hddtemp /dev/'.$drive . ' 2> /dev/null', $hddtemp);
            
            if ($hddtemp) {
                $hddtemp = $hddtemp[0];
                @preg_match('#:\s+([\d]+)#', $hddtemp, $matches);
                $this->{$drive}->temp = $matches[1];
            }
        }
    }

}