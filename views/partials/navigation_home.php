<h2 class="content_title"><img src="<?= $modules_assets ?>profiles_32.png"> Profiles</h2>
<ul class="content_navigation">
	<?= navigation_list_btn('home/profiles', 'Recent') ?>
	<?= navigation_list_btn('home/profiles/custom', 'Custom') ?>
	<?php if ($logged_user_level_id <= 2) echo navigation_list_btn('home/profiles/manage', 'Manage', $this->uri->segment(4)) ?>
</ul>