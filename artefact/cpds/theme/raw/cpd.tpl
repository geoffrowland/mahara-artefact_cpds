{include file="header.tpl"}
<div id="cpdswrap">
    <div class="rbuttons">
        <a class="btn" href="{$WWWROOT}artefact/cpds/new.php?id={$cpd}">{str section="artefact.cpds" tag="newactivity"}</a>
    </div>
    {if $tags}<p class="tags s"><label>{str tag=tags}:</label> {list_tags owner=$owner tags=$tags}</p>{/if}
{if !$activities.data}
    <div>{str tag="cpdsactivitiesdesc" section="artefact.cpds"}</div>
    <div class="message">{$strnoactivitiesaddone|safe}</div>
{else}
<table id="activitieslist" class="fullwidth listing">
    <thead>
        <tr>
            <th>{str tag='startdate' section='artefact.cpds'}</th>
            <th>{str tag='enddate' section='artefact.cpds'}</th>
            <th>{str tag='title' section='artefact.cpds'}</th>
            <th>{str tag='description' section='artefact.cpds'}</th>
            <th class="right">{str tag='hours' section='artefact.cpds'}</th>
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
