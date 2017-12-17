{* Smarty *}

{extends file="layout.tpl"}

{block name="body"}
{if $errors && 302|array_key_exists:$errors}
<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.302}}</div>
{elseif $errors && 229|array_key_exists:$errors}
<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.229}}</div>
{elseif $errors && 231|array_key_exists:$errors}
<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.231}}</div>

{else}
<form class="form" role="form" action="{$smarty.const.FILENAME_ASSIGN_VEHICLE}?users_id={$user->getUserId()}" method="POST">
	<input type="hidden" name="csrfToken" value="{$csrfToken}">
	<input type="hidden" name="action" value="assign_vehicle">
	<h3>Assign User Vehicle</h3>
	{if $successful_update}
	<div class="alert alert-success" role="alert">Update was successful</div>
	{/if}

	
	<h4><img src="{$user->getProfileImage()}" class="row-image"> {$user->getName()} <small>({$user->getEmailAddress()})</small></h4>
	
	<div class="form-group {if ($errors.230 neq NULL) or ($errors.232 neq NULL)}has-error{/if}">
		<label for="registration_number">Vehicle:</label>
		<select name="registration_number" id="registration_number">
			{foreach $available_vehicles as $vehicle}
				<option value="{$vehicle->getRegNr()}">{$vehicle->getRegNr()}, ({$vehicle->getMake()}, {$vehicle->getModel()}, {$vehicle->getYear()})</option>
			{foreachelse}
				<option disabled>No vehicles are available</option>
			{/foreach}	
		</select>
		{if is_array($errors) and array_key_exists(230,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.230}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(232,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.232}}</div>

		{/if}
	</div>

	<button type="submit" class="btn btn-primary">Assign Vehicle</button>

	
</form>

{/if}
{/block}