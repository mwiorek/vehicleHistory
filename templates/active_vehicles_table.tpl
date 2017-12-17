{* smarty *}
<h3>Available Drivers</h3>
<table class="table">
	<tr>
		<th></th>
		<th>Drivers Name</th>
		<th>Drivers Email</th>
		<th></th>
	</tr>
	{foreach $available_drivers as $driver} 
	<tr>
		<td><img src="{$driver->getProfileImage()}" class="row-image"></td>
		<td>{$driver->getName()}</td>
		<td>{$driver->getEmailAddress()}</td>
		<td><a href="{$smarty.const.FILENAME_ASSIGN_VEHICLE}?users_id={$driver->getUserId()}">Assign to vehicle</a></td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="2">
			No available drivers
		</td> 
	</tr>
	{/foreach}
</table>


<h3>Drivers with active vehicles</h3>
<table class="table">
	<tr>
		<th></th>
		<th>Driver Name</th>
		<th>Registration Number</th>
		<th>Date assigned</th>
		<th>Date checked out</th>
		<th></th>
	</tr>
	{foreach $active_drivers as $driver_entry} 
	<tr>
		<td><img src="{$driver_entry->getProfileImage()}" class="row-image"></td>
		<td>{$driver_entry->getUserName()}</td>
		<td>{$driver_entry->getRegNr()}</td>
		<td>{$driver_entry->getDateAssigned()}</td>
		<td>{$driver_entry->getDateCheckedOut()}</td>
		<td>
			{if $driver_entry->getDateCheckedOut() eq NULL }
			<a href="remove_assignment.php?entry_id={$driver_entry->getEntryId()}">Remove Assignment</a>
			{/if}
		</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="4">
			No active drivers
		</td> 
	</tr>
	{/foreach}
</table>
