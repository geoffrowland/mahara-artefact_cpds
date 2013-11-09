{if $tags}<p class="tags s"><label>{str tag=tags}:</label> {list_tags owner=$owner tags=$tags}</p>{/if}
<table id="activitytable">
    <thead>
        <tr>
            <th class="c1">{str tag='startdate' section='artefact.cpds'}</th>
            <th class="c2">{str tag='enddate' section='artefact.cpds'}</th>
            <th class="c3">{str tag='title' section='artefact.cpds'}</th>
            <th class="c4 right">{str tag='hours' section='artefact.cpds'}</th>
        </tr>
    </thead>
    <tbody>
    {$activities.tablerows|safe}
    </tbody>
</table>
<div id="cpds_page_container">{$activities.pagination|safe}</div>
<script>
{literal}
function rewriteactivityTitles() {
    forEach(
        getElementsByTagAndClassName('a', 'activity-title','activitytable'),
        function(element) {
            connect(element, 'onclick', function(e) {
                e.stop();
                var description = getFirstElementByTagAndClassName('div', 'activity-desc', element.parentNode);
                toggleElementClass('hidden', description);
            });
        }
    );
}

addLoadEvent(function() {
    {/literal}{$activities.pagination_js|safe}{literal}
    removeElementClass('cpds_page_container', 'hidden');
});

function activityPager() {
    var self = this;
    paginatorProxy.addObserver(self);
    connect(self, 'pagechanged', rewriteactivityTitles);
}
var activityPager = new activityPager();
addLoadEvent(rewriteactivityTitles);
{/literal}
</script>
