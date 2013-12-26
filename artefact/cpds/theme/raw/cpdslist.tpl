{foreach from=$cpds.data item=cpd}
    <tr class="{cycle values='r0,r1'}">
        <td>
            <div class="fr cpdstatus">
                 <a href="{$WWWROOT}artefact/cpds/edit/index.php?id={$cpd->id}" title="{str tag="edit"}" ><img src="{theme_url filename='images/btn_edit.png'}" alt="{str tag=edit}"></a>
                 <a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}" title="{str tag=manageactivities section=artefact.cpds}"><img src="{theme_url filename='images/btn_configure.png'}" alt="{str tag=managetasks}"></a>
                 <a href="{$WWWROOT}artefact/cpds/delete/index.php?id={$cpd->id}" title="{str tag="delete"}"><img src="{theme_url filename='images/btn_deleteremove.png'}" alt="{str tag=delete}"></a>
            </div>

            <h3><a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}">{$cpd->title}</a></h3>

            {if $cpd->tags}
                <div>{str tag=tags}: {list_tags tags=$cpd->tags owner=$cpd->owner}</div>
            {/if}

            <div class="codesc">{$cpd->description|clean_html|safe}</div>
        </td>
    </tr>
