{include file="header.tpl"}
<div id="cpdwrap">
    <div class="btn-top-right btn-group btn-group-top">
        <a <a class="btn btn-default settings" href="{$WWWROOT}artefact/cpds/new.php?id={$cpd}">
            <span class="icon icon-lg icon-plus left"></span>
            {str section="artefact.cpds" tag="newactivity"}
        </a>
    </div>
    {if !$activities.data}
        <div class="metadata">{$strnoactivitiesaddone|safe}</div>
    {else}
        <table id="cpdslist">
            <thead>
                <tr>
                    <th>{str tag='startdate' section='artefact.cpds'}</th>
                    <th>{str tag='enddate' section='artefact.cpds'}</th>
                    <th>{str tag='title' section='artefact.cpds'}</th>
                    <th>{str tag='description' section='artefact.cpds'}</th>
                    <th class="text-right">{str tag='hours' section='artefact.cpds'}</th>
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

