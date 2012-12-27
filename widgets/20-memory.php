<div class="component">
    <div class="header">
        <?php echo $system->memory->brand; ?> <?php echo $system->memory->type; ?> <?php echo $system->memory->speed; ?>
    </div>
        <?php if ($system->memory->percentage < 70): ?>
            <div class="state green">
        <?php elseif ($system->memory->percentage < 80): ?>
            <div class="state yellow">
        <?php else: ?>
            <div class="state red">
        <?php endif; ?>
            <?php echo round($system->memory->used / 1000); ?> MB
        </div>
    <div class="information">
        <ul>
            <li>
                <small>Total</small>
                <?php echo round($system->memory->total / 1000); ?> MB
            </li>
            <li>
                <small>Free</small>
                <?php echo round($system->memory->free / 1000); ?> MB
            </li>
            <li>
                <small>Percent.</small>
                <?php echo round($system->memory->percentage); ?>%
            </li>
        </ul>
    </div>
</div>