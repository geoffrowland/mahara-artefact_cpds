{auto_escape on}
{include file="header.tpl"}
<div id="cpdswrap">
    <div class="rbuttons">
        <a class="btn" href="{$WWWROOT}artefact/cpds/new/activity.php">{str section="artefact.cpds" tag="newactivity"}</a>
    </div>
{if !$activities.data}
    <div class="message">{$strnoactivitiesaddone|safe}</div>
{else}
<table id="cpdslist">
    <thead>
        <tr>
            <th>{str tag='startdate' section='artefact.cpds'}</th>
            <th>{str tag='enddate' section='artefact.cpds'}</th>
            <th>{str tag='title' section='artefact.cpds'}</th>
            <th>{str tag='description' section='artefact.cpds'}</th>
            <th class="right">{str tag='hours' section='artefact.cpds'}</th>
            <th class="cpdscontrols"></th>
            <th class="cpdscontrols"></th>
        </tr>
    </thead>
    <tbody>
        {$activities.tablerows|safe}
    </tbody>
</table>
   {$activities.pagination|safe}
{/if}
</div>
{include file="footer.tpl"}
{/auto_escape}