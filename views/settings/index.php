<form name="settings_update" id="settings_update" method="post" action="<?= base_url() ?>api/settings/modify" enctype="multipart/form-data">
<div class="content_wrap_inner">

	<div class="content_inner_top_right">
		<h3>App</h3>
		<p><?= form_dropdown('enabled', config_item('enable_disable'), $settings['people']['enabled']) ?></p>
		<p><a href="<?= base_url() ?>api/<?= $this_module ?>/uninstall" id="app_uninstall" class="button_delete">Uninstall</a></p>
	</div>

	<h3>Profiles</h3>

	<p>Activity
	<?= form_dropdown('profile_activity', config_item('yes_or_no'), $settings['people']['profile_activity']) ?>
	</p>

	<p>Friends / Followers
	<?= form_dropdown('profile_relationships', config_item('yes_or_no'), $settings['people']['profile_relationships']) ?>
	</p>
		
	<p>Content
	<?= form_dropdown('profile_content', config_item('yes_or_no'), $settings['people']['profile_content']) ?>
	</p>		

	<input type="hidden" name="module" value="<?= $this_module ?>">

	<p><input type="submit" name="save" value="Save" /></p>

</div>
</form>

<?= $shared_ajax ?>