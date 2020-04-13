{include file="header.tpl"}
<div class="btn-top-right btn-group btn-group-top">
    <a class="btn btn-secondary settings" href="{$WWWROOT}artefact/cpds/new.php?id={$cpd}">
        <span class="icon icon-lg icon-plus left"></span>
        {str section="artefact.cpds" tag="newcpd"}
    </a>
</div>
<div id="cpdslist" class="view-container">
    {if !$cpds.data}
    <div class="no-results">
        {$strnocpdsaddone|safe}
    </div>
    {else}
        {$cpds.tablerows|safe}
        {$cpds.pagination|safe}
    {/if}
</div>
{include file="footer.tpl"}
