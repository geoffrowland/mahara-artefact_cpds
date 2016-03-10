<div class="list-group list-group-lite">
{foreach from=$cpds.data item=cpd}
    <div class="list-group-item">
        <div class="clearfix">
            <h3 class="list-group-item-heading">
                <a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}">
                    {$cpd->title}
                </a>
            </h3>
            <div class="list-group-item-controls">
                <div class="btn-group btn-group-top">
                     <a href="{$WWWROOT}artefact/cpds/edit/index.php?id={$cpd->id}" title="{str tag="edit"}" class="btn btn-default btn-sm">
                        <span class="icon icon-lg icon-pencil" aria-hidden="true" role="presentation"></span>
                        <span class="sr-only">{str tag=edit}</span>
                    </a>
                     <a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}" title="{str tag=manageactivities section=artefact.cpds}" class="btn btn-default btn-sm">
                        <span class="icon icon-lg icon-cog" aria-hidden="true" role="presentation"></span>
                        <span class="sr-only">{str tag=managetasks section=artefact.plans}</span>
                    </a>
                     <a href="{$WWWROOT}artefact/cpds/delete/index.php?id={$cpd->id}" title="{str tag="delete"}" class="btn btn-default btn-sm">
                        <span class="icon icon-trash text-danger icon-lg" aria-hidden="true" role="presentation"></span>
                        <span class="sr-only">{str tag=delete}</span>
                    </a>
                </div>
            </div>
        </div>

        <p class="detail">
            {$cpd->description}
        </p>
        {if $cpd->tags}

        <div class="tags">
            <strong>{str tag=tags}:</strong> {list_tags tags=$cpd->tags owner=$cpd->owner}
        </div>
        {/if}
    </div>
{/foreach}
