{* smarty *}
<h3>Users</h3>
<table class="table">
	<tr>
		<th></th>
		<th>Name</th>
		<th>Email Address</th>
		<th>Roles</th>
		<th></th>
	</tr>
	{foreach $user_list as $user} 
	<tr>
		<td><img src="{$user->getProfileImage()}" class="row-image"></td>
		<td>{$user->getName()}</td>
		<td>{$user->getEmailAddress()}</td>
		<td>{'<br/> '|implode:$user->getUserRole()}</td>
		<td><a href="{$smarty.const.FILENAME_SETTINGS}?users_id={$user->getUserId()}">Edit User</a></td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="5">
			No users registered
		</td> 
	</tr>
	{/foreach}
</table>
<a href="{$smarty.const.FILENAME_REGISTER}">+ Add User</a>