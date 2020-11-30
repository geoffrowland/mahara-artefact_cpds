{if $nocpds && $editing}
    <div class="lead text-center content-text">{$nocpds}</div>
{else}
<div class="listing">
    {if $description || $tags}
    <div class="details-before-list-group">
        {if $description}<p class="text-midtone description">{$description}</p>{/if}
        {if $tags}
        <p class="text-midtone tags">
            <strong>{str tag=tags}:</strong> {list_tags owner=$owner tags=$tags}
        </p>
        {/if}
    </div>
    {/if}
    {if $activities.data}
        <div id="activitytable_{$blockid}" class="list-group list-unstyled{if $editing} list-group-top-border clearboth{/if}">
            {$activities.tablerows|safe}
        </div>
        {if $activities.pagination}
        <div id="cpds_page_container_{$blockid}" class="hidden">
            {$activities.pagination|safe}
        </div>
        <script>
        jQuery(function() {literal}{{/literal}
            {$activities.pagination_js|safe}
            jQuery('#cpds_page_container_{$blockid}').removeClass('hidden');
        {literal}}{/literal});
        </script>
        {/if}
    {else}
        <div class="lead text-center content-text">{str tag='noactivities' section='artefact.cpds'}</div>
    {/if}
</div>
{/if}
