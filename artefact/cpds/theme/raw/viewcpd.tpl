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
jQuery(function() {literal}{{/literal}
    {$activities.pagination_js|safe}
    jQuery('#cpds_page_container').removeClass('hidden');
{literal}}{/literal});
</script>