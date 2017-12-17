{* Smarty *}

{extends file="layout.tpl"}

{block name="body"}
{if $errors && 302|array_key_exists:$errors}
<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.302}}</div>
{elseif $errors && 229|array_key_exists:$errors}
<div class="alert alert-danger" role="alert">{$smarty.const.{$errors.229}}</div>
{/if}
{/block}