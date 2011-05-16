{foreach from=$cpds.data item=cpd}
    <tr class="{cycle values='r0,r1'}">
        <td>
            <div class="fr">
                <ul class="groupuserstatus">
                    <li><a href="{$WWWROOT}artefact/cpds/edit/index.php?id={$cpd->id}" class="icon btn-edit">{str tag="edit"}</a></li>
                    <li><a href="{$WWWROOT}artefact/cpds/delete/index.php?id={$cpd->id}" class="icon btn-del">{str tag="delete"}</a></li>
                </ul>
            </div>

            <h3><a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}">{$cpd->title}</a></h3>

        <div class="codesc">{$cpd->description}</div>
        <div class="fl">
            <ul class="cpdslist">
                <li><a class="icon btn-manage" href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}">{str tag="manageactivities" section="artefact.cpds"}</a></li>
            </ul>
        </div>
        </td>
    </tr>
