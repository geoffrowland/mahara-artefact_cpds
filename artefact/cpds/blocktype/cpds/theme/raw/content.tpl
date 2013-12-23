<div class="blockinstance-content">
{if $tags}<p class="tags s"><label>{str tag=tags}:</label> {list_tags owner=$owner tags=$tags}</p>{/if}
{if $activities.data}
<table id="activitytable_{$blockid}" class="cpdsblocktable fullwidth">
    <thead>
        <tr>
            <th class="c1">{str tag='startdate' section='artefact.cpds'}</th>
            <th class="c2">{str tag='enddate' section='artefact.cpds'}</th>
            <th class="c3">{str tag='title' section='artefact.cpds'}</th>
            <th class="c4" style="text-align:right">{str tag='hours' section='artefact.cpds'}</th>
        </tr>
    </thead>
    <tbody>
    {$activities.tablerows|safe}
    </tbody>
</table>
{if $activities.pagination}
<div id="cpds_page_container">{$activities.pagination|safe}</div>
{/if}
{if $activities.pagination_js}
<script>
{literal}
function rewriteactivityTitles() {
    forEach(
{/literal}
        getElementsByTagAndClassName('a', 'activity-title','activitytable_{$blockid}'),
{literal}
        function(element) {
            connect(element, 'onclick', function(e) {
                e.stop();
                var description = getFirstElementByTagAndClassName('div', 'activity-desc', element.parentNode);
                toggleElementClass('hidden', description);
            });
        }
    );
}

addLoadEvent(function() {{/literal}
    {$activities.pagination_js|safe}
    removeElementClass('cpds_page_container', 'hidden');
{literal}}{/literal});

function activityPager_{$blockid}() {literal}{
    var self = this;
    paginatorProxy.addObserver(self);
    connect(self, 'pagechanged', rewriteactivityTitles);
}
{/literal}
var activityPager_{$blockid} = new activityPager_{$blockid}();
addLoadEvent(rewriteactivityTitles);
</script>
{/if} {* pagination_js *}
{else}
    <p>{str tag='noactivities' section='artefact.cpds'}</p>
{/if}
</div>
