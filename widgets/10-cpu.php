<div class="component">
	<div class="header">
		<?php echo str_replace(array('(R)', '(TM)', ' CPU'), '', $system->cpu->name); ?>
	</div>
	<?php
	    $class = 'green';
	    if($system->cpu->frequency >= 1700) $class = 'yellow';
	?>
	
	<div class="state <?php echo $class; ?>">
	    <?php echo number_format($system->cpu->load, 2); ?> %
	</div>
	<div class="information">
    	<ul>
    		<li>
    			<small>Frequency</small>
    			<?php echo number_format($system->cpu->frequency); ?> GHz
    		</li>
    		<li>
    			<small>5 minutes</small>
    			<?php echo number_format($system->cpu->load5, 2); ?> %
    		</li>
    		<li>
    			<small>15 minutes</small>
    			<?php echo number_format($system->cpu->load15, 2); ?> %
    		</li>
    	</ul>
    </div>
</div>