<?php

class Network {

	function __construct() {

        exec("wget -q -O - checkip.dyndns.org|sed -e 's/.*Current IP Address: //' -e 's/<.*$//'", $ip);
        $this->ip = $ip[0];

		$nets = (array) @glob('/sys/class/net/*', GLOB_NOSORT);
        foreach ($nets as $net) {
            $adapter = basename($net);
            $state = read($net . '/operstate');

            if ($state == 'unknown' || $state == '')
                continue;
            
            $this->{$adapter}['received'] = read($net . '/statistics/rx_bytes');
            $this->{$adapter}['sent'] = read($net . '/statistics/tx_bytes');
            $this->{$adapter}['total'] = $this->{$adapter}['sent'] + $this->{$adapter}['received'];
            $this->{$adapter}['state'] = $state;
            $this->{$adapter}['errors'] = (int)read($net . '/statistics/rx_errors') + (int)read($net . '/statistics/tx_errors');
        }

        unset($nets);
	}

}