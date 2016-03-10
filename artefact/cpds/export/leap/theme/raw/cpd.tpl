{include file="export:leap:entry.tpl" skipfooter=true}
{if $hours}
        <mahara:hours>{$hours}</mahara:hours>
{/if}
{if $location}
        <leap2:spatial>{$location}</leap2:spatial>
{/if}
{include file="export:leap:entryfooter.tpl"}
