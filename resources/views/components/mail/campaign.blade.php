<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent" align="center" style="font-family:Helvetica, Arial,serif;">
    <tbody>
    <tr>
        <td>
            <div class="movableContent" style="margin: 0; border: 0px; padding-top: 0px; position: relative;">

                @php
                    \URL::forceRootUrl("https://" . tenant("domain"));
                    \URL::forceScheme('https');
                @endphp

                @include("components.mail.campaignHeader", ['campaign_id'=>$data['campaign_id']])
                    {!!html_entity_decode($data['body'])?? ''!!}
                @include("components.mail.footer")
            </div>
        </td>
    </tr>
    </tbody>
</table>
