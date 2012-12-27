<?php foreach($system->network as $name=>$network): ?>
<?php if (is_array($network)): ?>
<div class="component">
    <div class="header">
        Ethernet <?php echo $name; ?>
    </div>
        <?php if($network['state'] == 'up'): ?>
        <div class="state green">
        <?php else: ?>
        <div class="state gray">
        <?php endif; ?>
        
        <?php 
        $mb = $network['total'] / 1000000;
        echo $mb > 1000 ? number_format($mb/1000, 1) . ' GB' : number_format($mb, 1) . ' MB';
        ?>
        
        <small <?php echo $network['state'] == "up" ? 'class="green"' : ''; ?>><?php echo $system->network->ip; ?></small>
    </div>
    <div class="information">
        <ul>
            <li>
                <small>Sent</small>
                <?php 
                $mb = $network['sent'] / 1000000;
                echo $mb > 1000 ? round($mb/1000, 1) . ' GB' : round($mb, 1) . ' MB';
                ?>
            </li>
            <li>
                <small>Received</small>
                <?php 
                $mb = $network['received'] / 1000000;
                echo $mb > 1000 ? round($mb/1000, 1) . ' GB' : round($mb, 1) . ' MB';
                ?>
            </li>
            <li>
                <small>Errors</small>
                <?php echo $network['errors']; ?>
            </li>
        </ul>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>