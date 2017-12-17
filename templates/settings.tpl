{* Smarty *}

{extends file="layout.tpl"}

{block name="body"}

<form class="form" role="form" action="{$smarty.const.FILENAME_SETTINGS}{$url_params}" method="POST" enctype="multipart/form-data"> 
	<input type="hidden" name="csrfToken" value="{$csrfToken}">
	<input type="hidden" name="action" value="update">
	<h3>Change Basic Information</h3>
	{if $successful_update}
	<div class="alert alert-success" role="alert">Update was successful</div>
	{/if}
	{if $errors && 216|array_key_exists:$errors}
	<div class="alert alert-success" role="alert">{$smarty.const.{$errors.216}}</div>
	{/if}
	<div class="form-group {if $errors.203 neq NULL}has-error{/if}">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" class="form-control" placeholder="Name" required autofocus pattern="{literal}.{1,64}{/literal}" title="A valid name 1-64 letters" value="{$user->getName()}">
		{if is_array($errors) and array_key_exists(203,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.203}}</div>

		{/if}
	</div>

	<div class="media">
		<img src="{$user->getProfileImage()}" class="img-round">
		<div class="form-group {if ($errors.213 neq NULL) or ($errors.214 neq NULL) or ($errors.215 neq NULL)}has-error{/if}">
			<label for="name">Upload a new profile image:</label>
			<input type="file" id="profile_image" name="profile_image" class="form-control" placeholder="Choose an image" title="Upload a profile image" accept="image/*">
			{if is_array($errors) and array_key_exists(213,$errors)}

			<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.213}}</div>

			{/if}
			{if is_array($errors) and array_key_exists(214,$errors)}

			<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.214}}</div>

			{/if}
			{if is_array($errors) and array_key_exists(215,$errors)}

			<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.215}}</div>

			{/if}
		</div>
	</div>

	<div class="form-group {if ($errors.205 neq NULL) or ($errors.206 neq NULL) or ($errors.207 neq NULL)}has-error{/if}">
		<label for="email_address">Email Address:</label>
		<input type="email" id="email_address" name="email_address" class="form-control" placeholder="Email address" required value="{$user->getEmailAddress()}">
		{if is_array($errors) and array_key_exists(205,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.205}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(206,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.206}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(207,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.207}}</div>

		{/if}
	</div>
	<h3>Change Password</h3>
	<div class="form-group {if ($errors.202 neq NULL) or ($errors.211 neq NULL)}has-error{/if}">
		<label for="old_password">Old Password:</label>
		<input type="password" id="old_password" name="old_password" class="form-control" placeholder="Old Password">
		{if is_array($errors) and array_key_exists(202,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.202}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(211,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.211}}</div>

		{/if}
	</div>

	<div class="form-group {if ($errors.212 neq NULL) or ($errors.210 neq NULL)}has-error{/if}">
		<label for="new_password">New Password:</label>
		<input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password">
		{if is_array($errors) and array_key_exists(212,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.212}}</div>

		{/if}
	</div>

	<div class="form-group {if ($errors.209 neq NULL) or ($errors.210 neq NULL)}has-error{/if}">
		<label for="new_password_confirmation">Confirm New Password:</label>
		<input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Confirm Password">
		{if is_array($errors) and array_key_exists(209,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.209}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(210,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.210}}</div>

		{/if}
	</div>

	<div class="form-group">
		<label>Roles:</label>
		{foreach $user_to_roles as $role => $value}
			
			<label><input type="checkbox" name="roles[]" value="{$role}" {if $value}checked{/if}>{$role}</label>
		
		{/foreach}
	</div>

	<button class="btn btn-primary" type="submit">Confirm Changes</button>

</form>

<form method="POST" action="{$smarty.const.FILENAME_SETTINGS}{$url_params}" onSubmit="return confirmDelete()">
	<input type="hidden" name="csrfToken" value="{$csrfToken}">
	<input type="hidden" name="action" value="delete">
	<button type="submit">Delete Account</button>
</form>

<script type="text/javascript">
	function confirmDelete() {
		return confirm("Are you sure you want to permanently delete this account?");
	}
</script>
{/block}