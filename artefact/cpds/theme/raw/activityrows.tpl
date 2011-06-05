{$totalhours = 0}
{foreach from=$activities.data item=activity}
    <tr class="{cycle values='r0,r1'}" style="width:100%" >
        <td class="c1">{$activity->startdate}</td>
        <td class="c2">{$activity->enddate}</td>
        {if $activity->description}
            <td class="c3"><a class="activity-title" href="">{$activity->title} {str tag='at' section='artefact.cpds'} {$activity->location}</a>
            <div class="activity-desc hidden" id="activity-desc-{$activity->id}">{$activity->description}</div></td>
        {else}
            <td class="c3">{$activity->title} {str tag='at' section='artefact.cpds'} {$activity->location}</td>
        {/if}
        <td class="c4 right">{$activity->hours}</td>
    </tr>
{$totalhours = $totalhours + $activity->hours}
{/foreach}
<tr></tr>
<tr class="summaryhours">
<th colspan="3" class="right">{str tag='totalhours' section='artefact.cpds'}</th><td class="c4 right totalhours">{number_format($totalhours, 1)}</td>
</tr>