<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Notification | {{$website_name?? ''}}</title>
    <style type="text/css">
        @media only screen and (max-width:480px) {
            table[class="MainContainer"],
            td[class="cell"] {
                width: 100% !important;
                height: auto !important;
            }

            td[class="specbundle"] {
                width: 100% !important;
                float: left !important;
                font-size: 13px !important;
                line-height: 17px !important;
                display: block !important;
                padding-bottom: 15px !important;
            }

            td[class="spechide"] {
                display: none !important;
            }

            img[class="banner"] {
                width: 100% !important;
                height: auto !important;
            }

            td[class="left_pad"] {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
        }
        @media only screen and (max-width:540px) {
            table[class="MainContainer"],
            td[class="cell"] {
                width: 100% !important;
                height: auto !important;
            }

            td[class="specbundle"] {
                width: 100% !important;
                float: left !important;
                font-size: 13px !important;
                line-height: 17px !important;
                display: block !important;
                padding-bottom: 15px !important;
            }

            td[class="spechide"] {
                display: none !important;
            }

            img[class="banner"] {
                width: 100% !important;
                height: auto !important;
            }
        }
    </style>
</head>
@php
    \URL::forceRootUrl("https://" . tenant("domain"));
    \URL::forceScheme('https');
@endphp
<body paddingwidth="0" paddingheight="0" style="background-repeat: repeat; padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; margin: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; width: 100%;background-color: #edf2f7;" offset="0" toppadding="0" leftpadding="0">

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent" align="center" style="font-family:Helvetica, Arial,serif;">
        <tbody>
        <tr><td height="25"></td></tr>
        <tr>
            <td>
                @include("components.mail.header")
                {!! $body !!}
            </td>
        </tr>
        </tbody>
    </table>

    @include("components.mail.footer")

</body>
</html>
