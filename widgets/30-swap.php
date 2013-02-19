<div class="component">
    <div class="header">
        Swap
    </div>
        <?php if ($system->swap->percentage < 10): ?>
            <div class="state green">
        <?php elseif ($system->swap->percentage < 20): ?>
            <div class="state yellow">
        <?php else: ?>
            <div class="state red">
        <?php endif; ?>
            <?php echo round($system->swap->used / 1024); ?> MB
        </div>
    <div class="information">
        <ul>
            <li>
                <small>Total</small>
                <?php echo round($system->swap->total / 1024); ?> MB
            </li>
            <li>
                <small>Free</small>
                <?php echo round($system->swap->free / 1024); ?> MB
            </li>
            <li>
                <small>Percent.</small>
                <?php echo round($system->swap->percentage); ?>%
            </li>
        </ul>
    </div>
</div>