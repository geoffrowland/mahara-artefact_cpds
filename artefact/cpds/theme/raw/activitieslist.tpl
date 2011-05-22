{auto_escape on}
{$totalhours=0}
{foreach from=$activities.data item=activity}
        <tr class="{cycle values='r0,r1'}">
            <td class="c1">{$activity->startdate}</td>
            <td class="c2">{$activity->enddate}</td>
            <td class="c3">{$activity->title} {str tag='totalhours' section='artefact.cpds'} {$activity->location}</td>
            <td class="c5">{$activity->description}</td>
            <td class="c6" style="text-align:right">{$activity->hours}</td>
            <td class="c7 buttonscell"><a href="{$WWWROOT}artefact/cpds/edit/activity.php?id={$activity->activity}" title="{str tag=edit}"><img src="{theme_url filename='images/edit.gif'}" alt="{str tag=edit}"></a>
            <a href="{$WWWROOT}artefact/cpds/delete/activity.php?id={$activity->activity}" title="{str tag=delete}"><img src="{theme_url filename='images/icon_close.gif'}" alt="{str tag=delete}"></a></td>

        </tr>
{$totalhours = $totalhours + $activity->hours}
{/foreach}
<tr></tr>
<tr style="margin-top:px; border-style:solid; border-width: 1px 0px 1px 0px; border-color:#cccccc">
<th colspan="4" style="text-align:right; padding-right:0.5em">{str tag='totalhours' section='artefact.cpds'}</th><td style="text-align:right">{number_format($totalhours,1)}</td><td colspan="2"></td>
</tr>
{/auto_escape}