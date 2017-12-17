{* Smarty *}

{extends file="layout.tpl"}
{block name="body"}
<h4>{$sub_title}</h4>
{if ('DRIVER')|in_array:$user_roles}
{include 'drivers_table.tpl' activeVehicleList=$active_vehicles assignedVehicleList=$assigned_vehicles}
{/if}
{if ('ADM')|in_array:$user_roles or ('ADMIN')|in_array:$user_roles}
{include 'active_vehicles_table.tpl'}
{include 'vehicle_table.tpl' vehicleList=$available_vehicles title='Available Vehicles'}
{include 'vehicle_table.tpl' vehicleList=$all_vehicle_list title='All Vehicles'}
{/if}
{if ('ADMIN')|in_array:$user_roles}
{include 'all_user_table.tpl'}
{/if}
{/block}