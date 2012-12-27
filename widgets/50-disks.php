<?php foreach($system->disks as $i=>$disk): ?>
<div class="component">
    <div class="header">
        <?php echo $disk['name']; ?>
    </div>
        <?php
            $class = 'green';
            if($disk['temp'] > 35) $class = 'yellow';
            if($disk['temp'] > 40) $class = 'red';
            if($class != 'red' && $disk['percentage'] > 75) $class = 'yellow';
            if($disk['percentage'] > 85) $class = 'red';
        ?>
        <div class="state <?php echo $class; ?>">
        <?php echo round($disk['used'] / 1000000000, 1); ?> GB
    </div>
    <div class="information">
        <ul>
            <li>
                <small>Size</small>
                <?php echo floor($disk['size'] / 1000000000); ?>GB
            </li>
            <li>
                <small>Reads</small>
                <?php 
                if($disk['reads'] > 1000000) {
                    $k = $disk['reads'] / 1000000;
                    echo $k > 100 ? floor($k) . 'M' : number_format($k, 1) . 'M';
                } else if($disk['reads'] > 1000) {
                    $k = $disk['reads'] / 1000;
                    echo $k > 100 ? floor($k) . 'k' : number_format($k, 1) . 'k';
                } else {
                    echo $disk['reads'];
                }
                ?>
            </li>
            <li>
                <small>Writes</small>
                <?php 
                if($disk['writes'] > 1000000) {
                    $k = $disk['writes'] / 1000000;
                    echo $k > 100 ? floor($k) . 'M' : number_format($k, 1) . 'M';
                } else if($disk['writes'] > 1000) {
                    $k = $disk['writes'] / 1000;
                    echo $k > 100 ? floor($k) . 'k' : number_format($k, 1) . 'k';
                } else {
                    echo $disk['writes'];
                }
                ?>
            </li>
        </ul>
    </div>
</div>
<?php endforeach; ?>