{$totalhours = 0}
{foreach from=$activities.data item=activity}
<div class="list-group-item list-group-item-default">
    <a class="link-block collapsed" href="#expand-task-{$activity->id}" data-toggle="collapse" aria-expanded="false" aria-controls="expand-task-{$activity->id}">
        <span>
            {$activity->title}
        </span>
        <span class="pull-right">
            <span class="text-small text-midtone text-inline">
            {str tag='hours' section='artefact.cpds'}: {$activity->hours}
            </span>
            <span class="icon icon-chevron-down right collapse-indicator text-inline"></span>
        </span>
    </a>

    <div class="collapse" id="expand-task-{$activity->id}">
        <div class="panel-body">
            <p class="text-small text-midtone">
                {$activity->startdate}
                {if $activity->enddate} - {$activity->enddate}{/if}
            </p>

            {if $activity->description}
            <p>{$activity->description|clean_html|safe}</p>
            {/if}

            <p>
                <strong>{str tag='location' section='artefact.cpds'}:</strong>
                {$activity->location}
            </p>

            {if $activity->tags}
            <div class="tags">
                <strong>{str tag=tags}:</strong> {list_tags owner=$task->owner tags=$task->tags}
            </div>
            {/if}
        </div>
        {$totalhours = $totalhours + $activity->hours}
    </div>
</div>
{/foreach}
<div class="list-group-item">
    <div class="summaryhours">
        <div class="text-right totalhours">
            <strong>{str tag='totalhours' section='artefact.cpds'}:</strong> {number_format($totalhours, 1)}
        </div>
    </div>
</div>

