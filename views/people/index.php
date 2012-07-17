<h2>People</h2>

<p>This will be a directory of people on the given site</p>

<ul>
<?php if ($users): foreach ($users as $user): ?>
	<li><a href="<?= base_url().'people/'.$user->username ?>"><?= $user->name ?></a></li>
<?php endforeach; endif; ?>
</ul>