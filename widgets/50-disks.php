<?php foreach($system->disks as $i=>$disk): ?>
<div class="component">
    <div class="header">
        <?php echo $disk->name; ?>
    </div>
        <?php
            $class = 'green';
            if($disk->percentage > 85) $class = 'red';
            else if($disk->percentage > 75) $class = 'yellow';
        ?>
        <div class="state <?php echo $class; ?>">
        <?php
        if ($disk->used < 1073741824)
            echo round($disk->used / 1048576, 1) . ' MB';
        else
            echo round($disk->used / 1073741824, 1) . ' GB';
        ?>
    </div>
    <div class="information">
        <ul>
            <li>
                <small>Size</small>
                <?php echo floor($disk->size / 1073741824); ?>GB
            </li>
            <li>
                <small>Reads</small>
                <?php 
                if($disk->reads > 1048576) {
                    $k = $disk->reads / 1048576;
                    echo $k > 100 ? floor($k) . 'M' : number_format($k, 1) . 'M';
                } else if($disk->reads > 1024) {
                    $k = $disk->reads / 1024;
                    echo $k > 100 ? floor($k) . 'k' : number_format($k, 1) . 'k';
                } else {
                    echo $disk->reads;
                }
                ?>
            </li>
            <li>
                <small>Writes</small>
                <?php 
                if($disk->writes > 1048576) {
                    $k = $disk->writes / 1048576;
                    echo $k > 100 ? floor($k) . 'M' : number_format($k, 1) . 'M';
                } else if($disk->writes > 1024) {
                    $k = $disk->writes / 1024;
                    echo $k > 100 ? floor($k) . 'k' : number_format($k, 1) . 'k';
                } else {
                    echo $disk->writes;
                }
                ?>
            </li>
            <?php if (isset($disk->temp)): ?>
            <li>
                <small>Temp</small>
                <?php echo $disk->temp; ?>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php endforeach; ?>