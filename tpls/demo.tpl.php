<?php 
	$displayform = (!isset($hideform) || !$hideform);
?>

<style>
	ul				{ margin: 0px; padding: 0px; }
	ul li			{ margin: 0px; padding: 0px; position: relative; }
	ul li .admin	{ position: absolute; top: 5px; right: 5px; }
</style>

<ul>
	<?php foreach ($nodes as $node): ?>
    	<li>
    		<h3><?php echo $node['title'] ?></h3>
    		<p>
    			<?php echo $node['body'] ?>
	    		<?php if (count($node) > 3): ?>
	    			<ul>
		    			<?php foreach ($node as $k => $v): ?>
		    				<?php if (!in_array($k, array('_id', 'title', 'body'))): ?>
		    					<li>[<?php echo $k ?>] <?php echo $v ?></li>
		    				<?php endif; ?>
		    			<?php endforeach; ?>
	    			</ul>
	    		<?php endif; ?>	
    		</p>
    		<div class="admin">
    			<a href="?action=delete&_id=<?php echo $node['_id'] ?>">[delete]</a>
    		</div>
    	</li>
	<?php endforeach; ?>
</ul>

<?php if($displayform): ?>

<hr />

<form method="POST" action="?action=new">
	<input type="text" name="title" /> <br />
	<textarea name="body"></textarea> <br />
	<input type="submit" /> <br />
</form>

<?php endif; ?>