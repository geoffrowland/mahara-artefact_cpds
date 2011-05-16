{include file="header.tpl"}
<div id="cpdswrap">
    <div class="rbuttons">
        <a class="btn" href="{$WWWROOT}artefact/cpds/new.php">{str section="artefact.cpds" tag="newcpd"}</a>
    </div>
{if !$cpds.data}
    <div class="message">{$strnocpdsaddone|safe}</div>
{else}
<table id="cpdslist" class="fullwidth listing">
    <tbody>
        {$cpds.tablerows|safe}
    </tbody>
</table>
   {$cpds.pagination|safe}
{/if}
</div>
{include file="footer.tpl"}
