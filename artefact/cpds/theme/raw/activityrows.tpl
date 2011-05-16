{$totalhours = 0}
{foreach from=$activities.data item=activity}
    <tr class="{cycle values='r0,r1'}" style="width:100%" >
        <td class="c1">{$activity->startdate}</td>
        <td class="c2">{$activity->enddate}</td>
        {if $activity->description}
            <td class="c3"><a class="activity-title" href="">{$activity->title} at {$activity->location}</a>
            <div class="activity-desc hidden" id="activity-desc-{$activity->id}">{$activity->description}</div></td>
        {else}
            <td class="c3">{$activity->title} at {$activity->location}</td>
        {/if}
        <td class="c4" style="text-align:right">{$activity->hours}</td>
    </tr>
{$totalhours = $totalhours + $activity->hours}
{/foreach}
<tr></tr>
<tr style="border-width: 1px 0px 1px 0px; border-style:solid; border-color:#cccccc;">
<th class="c1"></th><th class="c2"></th><th class="c3" style="text-align:right; padding-right: 0.5em">{str tag='totalhours' section='artefact.cpds'}</th><td class="c4" style="text-align:right">{number_format($totalhours, 1)}</td>
</tr>