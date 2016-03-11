<div class="panel-body flush">
    <p class="description">{$description}</p>
    {if $tags}
    <p class="tags">
        <strong>{str tag=tags}:</strong> {list_tags owner=$owner tags=$tags}
    </p>
    {/if}
    {if $activities.data}
        <div id="activitytable_{$blockid}" class="list-group list-unstyled">
            {$activities.tablerows|safe}
        </div>
        {if $activities.pagination}
        <div id="cpds_page_container" class="hidden">
            {$activities.pagination|safe}
        </div>
        <script>
        addLoadEvent(function() {literal}{{/literal}
            {$activities.pagination_js|safe}
            removeElementClass('cpds_page_container', 'hidden');
        {literal}}{/literal});
        </script>
        {/if}
    {else}
        <div class="lead text-center content-text">{str tag='noactivities' section='artefact.cpds'}</div>
    {/if}
</div>

