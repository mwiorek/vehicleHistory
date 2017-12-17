{* Smarty *}
{include 'header.tpl'}
{block name="sidebar"}{include 'sidebar.tpl'}{/block}
<div class="container {block name=sidebar-class}{/block}">
    <h1 class="page_title">{$page_title}</h1>
    {block name="body"}{/block}
    {include 'footer.tpl'}
</div>
