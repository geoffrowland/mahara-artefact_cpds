<div class="plan-list-group list-group list-group-lite list-group-top-border">
{foreach from=$cpds.data item=cpd}
    <div class="list-group-item">
        <h2 class="list-group-item-heading text-inline">
            <a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}">
                {$cpd->title}
            </a>
        </h2>
        <div class="btn-top-right btn-group btn-group-top">
            <a href="{$WWWROOT}artefact/cpds/edit/index.php?id={$cpd->id}" title="{str tag="edit"}" class="btn btn-secondary btn-sm">
                <span class="icon icon-pencil-alt" aria-hidden="true" role="presentation"></span>
                <span class="sr-only">{str tag=edit}</span>
            </a>
            <a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}" title="{str tag=manageactivities section=artefact.cpds}" class="btn btn-secondary btn-sm">
                <span class="icon icon-cog" aria-hidden="true" role="presentation"></span>
                <span class="sr-only">{str tag=managetasks section=artefact.plans}</span>
            </a>
            <a href="{$WWWROOT}artefact/cpds/delete/index.php?id={$cpd->id}" title="{str tag="delete"}" class="btn btn-secondary btn-sm">
                <span class="icon icon-trash-alt text-danger" aria-hidden="true" role="presentation"></span>
                <span class="sr-only">{str tag=delete}</span>
            </a>
        </div>
        {if $cpd->description}
        <p class="detail">
            {$cpd->description}
        </p>
        {/if}
        {if $cpd->tags}
        <div class="tags text-small">
            <strong>{str tag=tags}:</strong> {list_tags tags=$cpd->tags owner=$cpd->owner}
        </div>
        {/if}
    </div>
{/foreach}
</div>