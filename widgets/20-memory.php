<div class="component">
    <div class="header">
        <?php
        if (isset($system->memory->brand))
            echo $system->memory->brand . ' ' . $system->memory->type . ' ' . $system->memory->speed;
        else
            echo "Memory";
        ?>

        <?php 
        if ($system->memory->total > 1000000) {
            echo number_format($system->memory->total / 1000000, 2) . ' GB';
        } else {
            echo round($system->memory->total / 1000) . ' MB';
        }
        ?>
    </div>
        <?php if ($system->memory->percentage < 75): ?>
            <div class="state green">
        <?php elseif ($system->memory->percentage < 90): ?>
            <div class="state yellow">
        <?php else: ?>
            <div class="state red">
        <?php endif; ?>
            <?php echo round($system->memory->used / 1024); ?> MB
        </div>
    <div class="information">
        <ul>
            <li>
                <small>Cached</small>
                <?php
                if ($system->memory->cached > 1048576) {
                    echo number_format($system->memory->cached / 1048576, 2) . ' GB';
                } else {
                    echo round($system->memory->cached / 1024) . ' MB';
                }
                ?>
            </li>
            <li>
                <small>Buffers</small>
                <?php
                if ($system->memory->buffers > 1048576) {
                    echo number_format($system->memory->buffers / 1048576, 2) . ' GB';
                } else {
                    echo round($system->memory->buffers / 1024) . ' MB';
                }
                ?>
            </li>
            <li>
                <small>Free</small>
                <?php echo round(100 - $system->memory->percentage); ?>%
            </li>
        </ul>
    </div>
</div>