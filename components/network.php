<?php

class Network {

    function __construct() {

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

            $this->{$adapter} = new stdClass;
            $this->{$adapter}->state = $state;
            $this->{$adapter}->speed = read('/sys/class/net/' . $adapter . '/speed');
            $this->{$adapter}->received = $parts[1];
            $this->{$adapter}->sent = $parts[9];
            $this->{$adapter}->total = $this->{$adapter}->sent + $this->{$adapter}->received;
            $this->{$adapter}->dropped = $parts[4] + $parts[12];
            $this->{$adapter}->errors = $parts[3] + $parts[11];

            /* --------------------------------------------------------------
             * ifconfig
             * -------------------------------------------------------------- */

            $ifconfig = array(); exec('/sbin/ifconfig ' . $adapter, $ifconfig);

            if ($ifconfig) {
                foreach ($ifconfig as $line) {
                    if (preg_match('/inet\saddr:\s*(\S*)/i', $line, $matches)) {
                        $this->{$adapter}->ip = $matches[1];
                    } else if (preg_match('/inet6\saddr:\s*(\S*)/i', $line, $matches)) {
                        $this->{$adapter}->ipv6 = $matches[1];
                    } else if (preg_match('/HWaddr\s*(\S*)/i', $line, $matches)) {
                        $this->{$adapter}->mac = $matches[1];
                    }
                }
            }
        }
    }

}