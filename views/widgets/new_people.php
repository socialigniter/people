<div class="widget_<?= $widget_region ?> widget_people_new_people" id="widget_<?= $widget_id ?>">
	<h2><?= $widget_title ?></h2>
	<ul>
	<?php if ($users): foreach ($users as $user): ?>
		<li><a href="<?= base_url().'people/'.$user->username ?>"><?= $user->name ?></a></li>
	<?php endforeach; else: ?>
		<li>No New People</li>
	<?php endif; ?>
	</ul>
</div>