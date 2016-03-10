{include file="header.tpl"}
<div class="btn-top-right btn-group btn-group-top">
    <a <a class="btn btn-default settings" href="{$WWWROOT}artefact/cpds/new.php?id={$cpd}">
        <span class="icon icon-lg icon-plus left"></span>
        {str section="artefact.cpds" tag="newactivity"}
    </a>
</div>
<div id="cpdslist" class="view-container">
    {if !$cpds.data}
    <div class="no-results">
        {$strnocpdsaddone|safe}
    </div>
    {else}
    <div id="cpdslist">
        {$cpds.tablerows|safe}
    </div>
   {$cpds.pagination|safe}
    {/if}
</div>
{include file="footer.tpl"}
