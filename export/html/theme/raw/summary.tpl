{if $cpds}
<ul>
{foreach from=$cpds item=cpd}
    <li><a href="{$cpd.link}">{$cpd.title}</a></li>
{/foreach}
</ul>
{/if}
