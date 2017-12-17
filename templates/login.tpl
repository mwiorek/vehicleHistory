{* Smarty *} 
{extends file="layout_nosidebar.tpl"}
{block name="title"}Login{/block}
{block name="body"}
<form class="form signin" role="form" action="{$smarty.const.FILENAME_LOGIN}" method="POST">
    <h2>Please sign in</h2>
    {if is_array($errors) and array_key_exists(301,$errors)}
    <div class="alert alert-danger" role="alert">{$smarty.const.{$errors.301}}</div>
    {/if}
    <input type="hidden" name="csrfToken" value="{$csrfToken}">
    <input type="hidden" name="action" value="login">
    <div class="form-group {if ($errors.201 neq NULL) or ($errors.207 neq NULL)}has-error{/if}">
        <label for="email_address">Email Address:</label>
        <input type="email" id="email_address" name="email_address" class="form-control" placeholder="Email address" required value="{if ($email_address neq NULL)}{$email_address}{/if}">
        {if is_array($errors) and array_key_exists(201,$errors)}
        <div class="alert alert-danger" role="alert">{$smarty.const.{$errors.201}}</div>
        {/if}
        {if is_array($errors) and array_key_exists(207,$errors)}
        <div class="alert alert-danger" role="alert">{$smarty.const.{$errors.207}}</div>
        {/if}
    </div>
    <div class="form-group {if $errors.202 neq NULL}has-error{/if}">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        {if is_array($errors) and array_key_exists(202,$errors)}
        <div class="alert alert-danger" role="alert">{$smarty.const.{$errors.202}}</div>
        {/if}
    </div>
    <div class="form-actions">
        <input class="btn btn-primary" type="submit" value="Sign in">
        <span> or </span>
        <a href="{$smarty.const.FILENAME_REGISTER}" class="btn">Register</a>
    </div>
</form>
{/block}