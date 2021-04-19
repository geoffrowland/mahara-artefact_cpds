{foreach from=$activities.data item=activity}
<div class="list-group-item task-item">
    <a class="outer-link collapsed" href="#expand-task-{$activity->id}{if $block}-{$block}{/if}{if $versioning}-{$versioning->version}{/if}" data-toggle="collapse" aria-expanded="false" aria-controls="expand-task-{$activity->id}{if $block}-{$block}{/if}{if $versioning}-{$versioning->version}{/if}">
        <span class="sr-only">{$activity->title}</span>
        <span class="icon icon-chevron-down right collapse-indicator float-right" style="margin-top: 0.9375rem; margin-right: 0.5rem;" role="presentation" aria-hidden="true"></span>
    </a>
    <h3 class="list-group-item-heading text-inline text-default"><a class="no-link">{$activity->title}</a></h3>
    <span class="float-right text-midtone text-small cpd-task-hours" style="margin-top: 0.125rem; margin-right: 0.9375rem;">{str tag='hours' section='artefact.cpds'}: {$activity->hours}</span>
    <div class="text-midtone text-small cpds-date">{$activity->startdateshort}{if $activity->enddateshort} - {$activity->enddateshort}{/if}</div>

    <div class="collapse cpd-activity-detail" id="expand-task-{$activity->id}{if $block}-{$block}{/if}{if $versioning}-{$versioning->version}{/if}">
        {if $activity->description}
        <div class="description">{$activity->description|clean_html|safe}</div>
        {/if}
        <div class="text-small">
            <strong>{str tag='location' section='artefact.cpds'}:</strong>
            {$activity->location}
        </div>
        {if $activity->tags}
            <div class="tags text-small">
                <strong>{str tag=tags}:</strong> {list_tags owner=$activity->owner tags=$activity->tags}
            </div>
        {/if}
    </div>
</div>
{/foreach}
<div class="list-group-item">
    <div class="summaryhours">
        <div class="text-right totalhours" style="margin-right: 0.9375rem;">
            <strong>{str tag='totalhours' section='artefact.cpds'}:</strong> {number_format($activities.grandtotalhours, 1)}
        </div>
    </div>
</div>
