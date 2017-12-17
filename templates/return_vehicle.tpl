{* Smarty *}

{extends file="layout.tpl"}

{block name="body"}
{if $errors && 301|array_key_exists:$errors}
<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.301}}</div>
{elseif $errors && 302|array_key_exists:$errors}
<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.302}}</div>
{elseif $errors && 229|array_key_exists:$errors}
<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.229}}</div>
{else}
<form class="form" role="form" action="{$smarty.const.FILENAME_RETURN_VEHICLE}?entry_id={$smarty.get.entry_id}" method="POST">
	<input type="hidden" name="csrfToken" value="{$csrfToken}">
	<input type="hidden" name="action" value="return">
	<h3>Return Vehicle <small>({$entry->getRegNr()})</small></h3>

	<div class="form-group {if ($errors.221 neq NULL) or ($errors.224 neq NULL)}has-error{/if}">
		<label for="mileage_end">Enter Final Mileage of vehicle</label>
		<input type="text" required autofocus pattern="\d+" name="mileage_end" id="mileage_end" placeholder="Enter current mileage (old: {$entry->getVehicleMileage()})" title="Only digits">
		{if is_array($errors) and array_key_exists(221,$errors)}
		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.221}}</div>
		{/if}
		{if is_array($errors) and array_key_exists(224,$errors)}
		<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.224}}</div>
		{/if}
	</div>
	<button type="submit" class="btn btn-primary">Return Vehicle</button>

	
</form>

{/if}
{/block}