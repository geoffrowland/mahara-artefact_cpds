{foreach from=$activities.data item=activity}
    <tr>
        <td>{$activity->startdate}</td>
        <td>{$activity->enddate}</td>
        <td>{$activity->title} ({$activity->location})</td>
        <td>{$activity->description}</td>
        <td class="hours text-right">{$activity->hours}</td>
        <td class="control-buttons text-right">
            <div class="btn-group">
                <a href="{$WWWROOT}artefact/cpds/edit/activity.php?id={$activity->activity}" title="{str tag=edit}" class="btn btn-secondary btn-sm">
                    <span class="icon icon-pencil-alt" aria-hidden="true" role="presentation"></span>
                    <span class="sr-only">{str tag=edit}</span>
                </a>
                <a href="{$WWWROOT}artefact/cpds/delete/activity.php?id={$activity->activity}" title="{str tag=delete}" class="btn btn-secondary btn-sm">
                    <span class="icon icon-trash-alt text-danger" aria-hidden="true" role="presentation"></span>
                    <span class="sr-only">{str tag=delete}</span>
                </a>
            </div>
        </td>
    </tr>
{/foreach}
    <tr class="summaryhours">
        <th colspan="4" class="text-right">{str tag='totalhours' section='artefact.cpds'}</th>
        <td class="text-right totalhours"><strong>{number_format($activities.grandtotalhours,1)}</strong></td>
        <td></td>
    </tr>
