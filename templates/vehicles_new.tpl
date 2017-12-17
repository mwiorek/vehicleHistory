{* Smarty *}

{extends file="layout.tpl"}

{block name="body"}

<form class="form" role="form" action="{$smarty.const.FILENAME_VEHICLE}" method="POST"> 
	<input type="hidden" name="csrfToken" value="{$csrfToken}">
	<input type="hidden" name="action" value="create">
	<h3>Vehicle Information</h3>
	<div class="form-group {if ($errors.217 neq NULL) or ($errors.222 neq NULL)}has-error{/if}">
		<label for="reg_nr">Registration Number:</label>
		<input type="text" id="regNr" name="reg_nr" class="form-control" placeholder="Registration Number e.g. ABC123" required autofocus pattern="{literal}([A-Z,a-z]){3}([0-9]){3}{/literal}" title="A valid registration number 6 characters" value="{$registration_number}">
		{if is_array($errors) and array_key_exists(217,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.217}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(222,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.222}}</div>

		{/if}
	</div>

	<div class="form-group {if ($errors.218 neq NULL)}has-error{/if}">
		<label for="make">Make:</label>
		<input type="text" id="make" name="make" class="form-control" placeholder="Vehicle Make" required value="{$make}">
		{if is_array($errors) and array_key_exists(218,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.218}}</div>

		{/if}
	</div>
	<div class="form-group {if ($errors.219 neq NULL)}has-error{/if}">
		<label for="model">Model</label>
		<input type="text" id="model" name="model" class="form-control" placeholder="Vehicle Model" required value="{$model}">
		{if is_array($errors) and array_key_exists(219,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.219}}</div>

		{/if}
	</div>
	<div class="form-group {if ($errors.220 neq NULL)}has-error{/if}">
		<label for="year">Year</label>
		<input type="text" id="year" name="year" class="form-control" placeholder="Vehicle Year" pattern="{literal}(([0-9]){4}{/literal}" required value="{$year}">
		{if is_array($errors) and array_key_exists(220,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.220}}</div>

		{/if}
	</div>
	<div class="form-group {if ($errors.221 neq NULL) or ($errors.221 neq NULL)}has-error{/if}">
		<label for="mileage">Mileage</label>
		<input type="text" id="mileage" name="mileage" class="form-control" placeholder="Mileage" required pattern="{literal}(([0-9])+{/literal}" value="{$mileage}">
		{if is_array($errors) and array_key_exists(221,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.221}}</div>

		{/if}
		{if is_array($errors) and array_key_exists(224,$errors)}

		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.224}}</div>

		{/if}
	</div>

	<button class="btn btn-primary" type="submit">Add Vehicle</button>

</form>

{/block}