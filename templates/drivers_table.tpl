{* smarty *}
<h3>Active Vehicles</h3>
<table class="table">
	<tr>
		<th>Registration Number</th>
		<th>Make</th>
		<th>Model</th>
		<th>Year</th>
		<th>Mileage</th>
		<th></th>
	</tr>
	{foreach $activeVehicleList as $entry_id => $vehicle} 
	<tr {if !$vehicle->getStatus()}class="row-error"{/if}>
		<td>{$vehicle->getRegNr()}</td>
		<td>{$vehicle->getMake()}</td>
		<td>{$vehicle->getModel()}</td>
		<td>{$vehicle->getYear()}</td>
		<td>{$vehicle->getMileage()}</td>
		<td><a href="{$smarty.const.FILENAME_RETURN_VEHICLE}?entry_id={$entry_id}">Return Vehicle</a></td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="6">
			No active vehicles
		</td> 
	</tr>
	{/foreach}
</table>

<h3>Assigned Vehicles</h3>
<table class="table">
	<tr>
		<th>Registration Number</th>
		<th>Make</th>
		<th>Model</th>
		<th>Year</th>
		<th>Mileage</th>
		<th></th>
	</tr>
	{foreach $assignedVehicleList as $entry_id => $vehicle} 
	<tr {if !$vehicle->getStatus()}class="row-error"{/if}>
		<td>{$vehicle->getRegNr()}</td>
		<td>{$vehicle->getMake()}</td>
		<td>{$vehicle->getModel()}</td>
		<td>{$vehicle->getYear()}</td>
		<td>{$vehicle->getMileage()}</td>
		<td><a href="{$smarty.const.FILENAME_CHECKOUT_VEHICLE}?entry_id={$entry_id}">Checkout Vehicle</a></td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="6">
			No assigned vehicles
		</td> 
	</tr>
	{/foreach}
</table>