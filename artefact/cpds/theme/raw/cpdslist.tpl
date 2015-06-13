{foreach from=$cpds.data item=cpd}
    <div class="{cycle values='r0,r1'} listrow">
        <h3 class="title"><a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}">{$cpd->title}</a></h3>
        <div class="fr cpdstatus">
            <a href="{$WWWROOT}artefact/cpds/edit/index.php?id={$cpd->id}" title="{str tag="edit"}" >
                <img src="{theme_url filename='images/btn_edit.png'}" alt="{str(tag=editspecific arg1=$cpd->title)|escape:html|safe}">
            </a>
            <a href="{$WWWROOT}artefact/cpds/cpd.php?id={$cpd->id}" title="{str tag=manageactivities section=artefact.cpds}">
                <img src="{theme_url filename='images/btn_configure.png'}" alt="{str(tag=managetasksspecific section=artefact.cpds arg1=$cpd->title)|escape:html|safe}">
            </a>
            <a href="{$WWWROOT}artefact/cpds/delete/index.php?id={$cpd->id}" title="{str tag="delete"}">
                <img src="{theme_url filename='images/btn_deleteremove.png'}" alt="{str(tag=deletespecific arg1=$cpd->title)|escape:html|safe}">
            </a>
        </div>
        <div class="detail">{$cpd->description|clean_html|safe}</div>
        {if $cpd->tags}
            <div>{str tag=tags}: {list_tags tags=$cpd->tags owner=$cpd->owner}</div>
        {/if}
        <div class="cb"></div>
    </div>
{/foreach}
