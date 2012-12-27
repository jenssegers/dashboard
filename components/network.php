<?php

class Network {

    function __construct() {

        /* --------------------------------------------------------------
         * Get remote ip
         * -------------------------------------------------------------- */
        exec("wget -q -O - checkip.dyndns.org|sed -e 's/.*Current IP Address: //' -e 's/<.*$//'", $ip);
        $this->ip = $ip[0];


        /* --------------------------------------------------------------
         * Network adapters
         * -------------------------------------------------------------- */
        $lines = explode("\n", read('/proc/net/dev'));

        foreach ($lines as $line) {
            if (!strpos($line, ':'))
                continue;
            
            $parts = preg_split('/\s+/', trim($line));
            $adapter = substr($parts[0], 0, -1);

            $state = read('/sys/class/net/' . $adapter . '/operstate');
            if ($state == 'unknown' || $state == '')
                continue;

            $this->{$adapter}['state'] = $state;
            $this->{$adapter}['received'] = $parts[1];
            $this->{$adapter}['sent'] = $parts[9];
            $this->{$adapter}['total'] = $this->{$adapter}['sent'] + $this->{$adapter}['received'];
            $this->{$adapter}['dropped'] = $parts[4] + $parts[12];
            $this->{$adapter}['errors'] = $parts[3] + $parts[11];
        }

        unset($nets);
    }

}