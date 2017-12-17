{* Smarty *}


<form class="form" role="form" action="{$smarty.const.FILENAME_REGISTER}" method="POST"> 
	<input type="hidden" name="csrfToken" value="{$csrfToken}">
	<input type="hidden" name="action" value="register">
	<h3>Register Account</h3>
	{if $errors && 302|array_key_exists:$errors}
	<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.302}}</div>
	{/if}
	<div class="form-group {if $errors.203 neq NULL}has-error{/if}">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" class="form-control" placeholder="Name" required autofocus pattern="{literal}.{1,64}{/literal}" title="A valid name 1-64 letters" value="{$name}">
		{if is_array($errors) and array_key_exists(203,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.203}}</div>

		{/if}
	</div>

	<div class="form-group {if ($errors.204 neq NULL) or ($errors.206 neq NULL) or ($errors.207 neq NULL)}has-error{/if}">
		<label for="email_address">Email Address:</label>
		<input type="email" id="email_address" name="email_address" class="form-control" placeholder="Email address" required value="{$email_address}">
		{if is_array($errors) and array_key_exists(204,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.204}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(206,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.206}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(207,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.207}}</div>

		{/if}
	</div>
	<div class="form-group {if ($errors.208 neq NULL) or ($errors.210 neq NULL)}has-error{/if}">
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" class="form-control" placeholder="Password">
		{if is_array($errors) and array_key_exists(208,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.208}}</div>

		{/if}
	</div>

	<div class="form-group {if ($errors.209 neq NULL) or ($errors.210 neq NULL)}has-error{/if}">
		<label for="password_confirmation">Confirm Password:</label>
		<input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password">
		{if is_array($errors) and array_key_exists(209,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.209}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(210,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.210}}</div>

		{/if}
	</div>

	<div class="form-group">
		<label>Roles:</label>
		{foreach $roles as $role}
			
			<label><input type="checkbox" name="roles[]" value="{$role}">{$role}</label>
		
		{/foreach}
	</div>

	<button class="btn btn-primary" type="submit">Register Account</button>

</form>
