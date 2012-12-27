<?php

class Disks {

    function __construct() {

        /* --------------------------------------------------------------
         * Disk information
         * -------------------------------------------------------------- */
        $paths = (array) @glob('/sys/block/*/device/model', GLOB_NOSORT);
        foreach ($paths as $path) {
            $dirname = dirname(dirname($path));
            $parts = explode('/', $path);
            $drive = $parts[3];
            
            if (preg_match('/^(\d+)\s+\d+\s+\d+\s+\d+\s+(\d+)\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+$/', read(dirname(dirname($path)) . '/stat'), $matches) !== 1) {
                $reads = 0;
                $writes = 0;
            } else {
                list(, $reads, $writes) = $matches;
            }
            
            $disks[$drive]['name'] = read($path);
            $disks[$drive]['size'] = read(dirname(dirname($path)) . '/size', 0) * 512;
            $disks[$drive]['reads'] = $reads;
            $disks[$drive]['writes'] = $writes;
            
            $df = exec('df /dev/' . $drive . '1');
            
            if (@preg_match('#\s+(\d+)\s+(\d+)\s+(\d+)#', $df, $matches)) {
                $disks[$drive]['used'] = $matches[2] * 1024;
                $disks[$drive]['percentage'] = $disks[$drive]['used'] / $disks[$drive]['size'] * 100;
            } else {
                $disks[$drive]['used'] = 'NA';
                $disks[$drive]['percentage'] = 0;
            }
            

            /* --------------------------------------------------------------
             * hddtemp
             * -------------------------------------------------------------- */
            exec('hddtemp /dev/'.$drive . ' 2> /dev/null', $hddtemp);
            
            if ($hddtemp) {
                $hddtemp = $hddtemp[0];
                @preg_match('#:\s+([\d]+)#', $hddtemp, $matches);
                $disks[$drive]['temp'] = $matches[1];
            }
            
            ksort($disks);

            foreach ($disks as $disk => $info) {
                $this->{$disk} = $info;
            }
        }


        /* --------------------------------------------------------------
         * VPS disks
         * -------------------------------------------------------------- */
        $paths = (array) @glob('/sys/block/xvd*', GLOB_NOSORT);
        foreach ($paths as $path) {
            $drive = basename($path);
            
            if (preg_match('/^(\d+)\s+\d+\s+\d+\s+\d+\s+(\d+)\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+$/', read(dirname(dirname($path)) . '/stat'), $matches) !== 1) {
                $reads = 0;
                $writes = 0;
            } else {
                list(, $reads, $writes) = $matches;
            }
            
            $disks[$drive]['name'] = read($path);
            $disks[$drive]['size'] = read(dirname(dirname($path)) . '/size', 0) * 512;
            $disks[$drive]['reads'] = $reads;
            $disks[$drive]['writes'] = $writes;
            
            $df = exec('df /dev/' . $drive);
            
            if (@preg_match('#\s+(\d+)\s+(\d+)\s+(\d+)#', $df, $matches)) {
                $disks[$drive]['used'] = $matches[2] * 1024;
                $disks[$drive]['percentage'] = $disks[$drive]['used'] / $disks[$drive]['size'] * 100;
            } else {
                $disks[$drive]['used'] = 'NA';
                $disks[$drive]['percentage'] = 0;
            }
        }
    }

}