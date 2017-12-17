{block name=sidebar}
<div class="navigation">
<ul class="nav nav-sidebar">
    <li {if {$smarty.server.SCRIPT_NAME|basename} == {$smarty.const.FILENAME_DEFAULT}} class="active"{/if}><a href="{$smarty.const.FILENAME_DEFAULT}">Dashboard</a></li>
    <li {if {$smarty.server.SCRIPT_NAME|basename} == {$smarty.const.FILENAME_SETTINGS}} class="active"{/if}><a href="{$smarty.const.FILENAME_SETTINGS}">Account Settings</a></li>
    <li><a href="{$smarty.const.FILENAME_LOGOUT}">Logout</a></li>
</ul>
</div>
{/block}