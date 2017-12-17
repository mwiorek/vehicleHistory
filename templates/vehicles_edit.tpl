{* Smarty *}

{extends file="layout.tpl"}

{block name="body"}

{if ($vehicle)}

<form class="form" role="form" action="{$smarty.const.FILENAME_VEHICLE}?reg_nr={$vehicle->getRegNr()}" method="POST"> 
	<input type="hidden" name="csrfToken" value="{$csrfToken}">
	<input type="hidden" name="action" value="update">
	<h3>Edit Vehicle Information</h3>
	{if $successful_update}
	<div class="alert alert-success" role="alert">Update was successful</div>
	{/if}
	{if is_array($errors) and array_key_exists(223,$errors)}
	<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.223}}</div>
	{/if}
		{if is_array($errors) and array_key_exists(225,$errors)}
	<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.225}}</div>
	{/if}
	<div class="form-group {if $errors.217 neq NULL}has-error{/if}">
		<label for="reg_nr">Registration Number:</label>
		<input type="text" id="reg_nr" name="reg_nr" class="form-control" placeholder="Registration Number" required autofocus pattern="([A-Z,a-z]){3}([0-9]){3}" title="A valid registration number 6 characters" value="{$vehicle->getRegNr()}" disabled>
		{if is_array($errors) and array_key_exists(217,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.217}}</div>

		{/if}
	</div>

	<div class="form-group {if ($errors.218 neq NULL)}has-error{/if}">
		<label for="make">Make:</label>
		<input type="text" id="make" name="make" class="form-control" placeholder="Vehicle Make" required value="{$vehicle->getMake()}">
		{if is_array($errors) and array_key_exists(218,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.218}}</div>

		{/if}
	</div>
	<div class="form-group {if ($errors.219 neq NULL)}has-error{/if}">
		<label for="model">Model</label>
		<input type="text" id="model" name="model" class="form-control" placeholder="Vehicle Model" value="{$vehicle->getModel()}">
		{if is_array($errors) and array_key_exists(219,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.219}}</div>

		{/if}
	</div>
	<div class="form-group {if ($errors.220 neq NULL)}has-error{/if}">
		<label for="year">Year</label>
		<input type="text" id="year" name="year" class="form-control" placeholder="Vehicle Year" pattern="(([0-9]){4}" value="{$vehicle->getYear()}">
		{if is_array($errors) and array_key_exists(220,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.220}}</div>

		{/if}
	</div>
	<div class="form-group {if ($errors.221 neq NULL) or ($errors.224 neq NULL)}has-error{/if}">
		<label for="mileage">Mileage</label>
		<input type="text" id="mileage" name="mileage" class="form-control" placeholder="Mileage" value="{$vehicle->getMileage()}">
		{if is_array($errors) and array_key_exists(221,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.221}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(224,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.224}}</div>

		{/if}
	</div>

	<button class="btn btn-primary" type="submit">Confirm Changes</button>

</form>

<form method="POST" action="{$smarty.const.FILENAME_VEHICLE}?reg_nr={$vehicle->getRegNr()}">
	<input type="hidden" name="csrfToken" value="{$csrfToken}">
	<button type="submit" name="action" value="toggle_status">{if $vehicle->getStatus()}Decommision Vehicle{else}Recommision Vehicle{/if}</button>
</form>
{else}
<div class="alert alert-danger" role="alert">
	<h3>Error</h3>
	<p>The requested vehicle was not found. Return and try again.</p>
</div>
{/if}
{/block}