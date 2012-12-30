<div class="component">
    <div class="header">
        <?php 
        if (isset($system->cpu->name))
            echo str_replace(array('(R)', '(TM)', ' CPU'), '', $system->cpu->name);
        else
            echo "CPU";
        ?>
    </div>
    <?php
        $class = 'green';
        if($system->cpu->load >= 80) $class = 'red';
        else if($system->cpu->load >= 10) $class = 'yellow';
    ?>
    
    <div class="state <?php echo $class; ?>">
        <?php echo number_format($system->cpu->load, 2); ?> %
    </div>
    <div class="information">
        <ul>
            <li>
                <small>Frequency</small>
                <?php echo number_format($system->cpu->frequency); ?> MHz
            </li>
            <li>
                <small>5 minutes</small>
                <?php echo number_format($system->cpu->load5, 2); ?> %
            </li>
            <?php if (isset($system->cpu->temp)): ?>
            <li>
                <small>Temp</small>
                <?php echo number_format($system->cpu->temp, 2); ?>&deg;
            </li>
            <?php else: ?>
            <li>
                <small>15 minutes</small>
                <?php echo number_format($system->cpu->load15, 2); ?> %
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>