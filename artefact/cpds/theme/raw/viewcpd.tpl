<p class="here">{$description}</p>
{if $tags}
<p class="tags">
    <strong>{str tag=tags}:</strong> {list_tags owner=$owner tags=$tags}
</p>
{/if}
<div>
    <ul id="activitylist" class="list-group list-unstyled">
        {$activities.tablerows|safe}
    </ul>
</div>
<div id="cpds_page_container" class="hidden">{$activities.pagination|safe}</div>
<script>
addLoadEvent(function() {literal}{{/literal}
    {$activities.pagination_js|safe}
    removeElementClass('cpds_page_container', 'hidden');
{literal}}{/literal});
</script>