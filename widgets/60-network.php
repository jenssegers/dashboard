<?php foreach($system->network as $name => $adapter): ?>
<div class="component">
    <div class="header">
        Ethernet <?php echo $name; ?>
        <?php if ($adapter->speed) echo $adapter->speed . ' MBIT'; ?>
    </div>
        <?php if($adapter->state == 'up'): ?>
        <div class="state green">
        <?php else: ?>
        <div class="state gray">
        <?php endif; ?>
        
        <?php 
        $mb = $adapter->total / 1048576;
        echo $mb > 1024 ? number_format($mb/1024, 1) . ' GB' : number_format($mb, 1) . ' MB';
        ?>
        
        <?php if(isset($adapter->ip)): ?>
        <small <?php echo $adapter->state == "up" ? 'class="green"' : ''; ?>><?php echo $adapter->ip; ?></small>
        <?php endif; ?>

    </div>
    <div class="information">
        <ul>
            <li>
                <small>Sent</small>
                <?php 
                $mb = $adapter->sent / 1048576;
                echo $mb > 1024 ? round($mb/1024, 1) . ' GB' : round($mb, 1) . ' MB';
                ?>
            </li>
            <li>
                <small>Received</small>
                <?php 
                $mb = $adapter->received / 1048576;
                echo $mb > 1024 ? round($mb/1024, 1) . ' GB' : round($mb, 1) . ' MB';
                ?>
            </li>
            <li>
                <small>Errors</small>
                <?php echo $adapter->errors; ?>
            </li>
        </ul>
    </div>
</div>
<?php endforeach; ?>