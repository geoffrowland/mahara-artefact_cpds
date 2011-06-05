{auto_escape on}
{$totalhours=0}
{foreach from=$activities.data item=activity}
        <tr class="{cycle values='r0,r1'}">
            <td class="c1">{$activity->startdate}</td>
            <td class="c2">{$activity->enddate}</td>
            <td class="c3">{$activity->title} {str tag='at' section='artefact.cpds'} {$activity->location}</td>
            <td class="c4">{$activity->description}</td>
            <td class="c5 right">{$activity->hours}</td>
            <td class="c6 buttonscell"><a href="{$WWWROOT}artefact/cpds/edit/activity.php?id={$activity->activity}" title="{str tag=edit}"><img src="{theme_url filename='images/edit.gif'}" alt="{str tag=edit}"></a>
            <a href="{$WWWROOT}artefact/cpds/delete/activity.php?id={$activity->activity}" title="{str tag=delete}"><img src="{theme_url filename='images/icon_close.gif'}" alt="{str tag=delete}"></a></td>
        </tr>
{$totalhours = $totalhours + $activity->hours}
{/foreach}
<tr></tr>
<tr class="summaryhours">
<th colspan="4" class="right">{str tag='totalhours' section='artefact.cpds'}</th><td class="right totalhours">{number_format($totalhours,1)}</td><td></td>
</tr>
{/auto_escape}