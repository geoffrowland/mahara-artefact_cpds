{foreach from=$activities.data item=activity}
<div class="list-group-item task-item">
    <a class="outer-link collapsed" href="#expand-task-{$activity->id}{if $block}-{$block}{/if}{if $versioning}-{$versioning->version}{/if}" data-toggle="collapse" aria-expanded="false" aria-controls="expand-task-{$activity->id}{if $block}-{$block}{/if}{if $versioning}-{$versioning->version}{/if}">
        <span class="sr-only">{$activity->title}</span>
        <span class="icon icon-chevron-down right collapse-indicator float-right text-inline" role="presentation" aria-hidden="true"></span>
    </a>
    <span class="text-default cpd-task-heading">{$activity->title}</span>
    <span class="float-right cpd-task-right" style="margin-right:15px;">
      <span class="text-small text-midtone text-inline cpd-task-hours">{str tag='hours' section='artefact.cpds'}: {$activity->hours}</span>
    </span>

    <div class="collapse plan-task-detail" id="expand-task-{$activity->id}{if $block}-{$block}{/if}{if $versioning}-{$versioning->version}{/if}">
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
            <div class="tags text-small">
                <strong>{str tag=tags}:</strong> {list_tags owner=$task->owner tags=$task->tags}
            </div>
        {/if}
    </div>
</div>
{/foreach}
<div class="list-group-item">
    <div class="summaryhours">
        <div class="text-right totalhours">
            <strong>{str tag='totalhours' section='artefact.cpds'}:</strong> {number_format($activities.grandtotalhours, 1)}
        </div>
    </div>
</div>
