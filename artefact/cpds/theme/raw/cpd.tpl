{include file="header.tpl"}
<div class="btn-top-right btn-group btn-group-top">
    <a class="btn btn-secondary settings" href="{$WWWROOT}artefact/cpds/new.php?id={$cpd}">
        <span class="icon icon-lg icon-plus left"></span>
        {str section="artefact.cpds" tag="newactivity"}
    </a>
</div>
<div id="cpdswrap" class="view-container">
    {if $tags}
    <p class="tags">
        <strong>{str tag=tags}:</strong>
        {list_tags owner=$owner tags=$tags}
    </p>
    {/if}

    {if !$activities.data}
    <div class="no-results">
        {str tag="cpdsactivitiesdesc" section="artefact.cpds"}
        <p>{$strnoactivitiesaddone|safe}</p>
    </div>
    {else}
    <div class="table-responsive">
        <table id="activitieslist" class="listing table table-striped text-small">
            <thead>
                <tr>
                    <th>{str tag='startdate' section='artefact.cpds'}</th>
                    <th>{str tag='enddate' section='artefact.cpds'}</th>
                    <th>{str tag='title' section='artefact.cpds'}</th>
                    <th>{str tag='description' section='artefact.cpds'}</th>
                    <th>{str tag='hours' section='artefact.cpds'}</th>
                    <th class="cpdscontrols"></th>
                </tr>
            </thead>
            <tbody>
                {$activities.tablerows|safe}
            </tbody>
        </table>
    </div>
    {$activities.pagination|safe}
    {/if}
</div>
{include file="footer.tpl"}
