<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Notification | BizinaBox</title>
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

            .font {
                font-size: 18px !important;
                line-height: 22px !important;
            }

            .font1 {
                font-size: 18px !important;
                line-height: 22px !important;
            }
        }
    </style>
    <script type="colorScheme" class="swatch active">
    {
        "name":"Default",
        "bgBody":"ffffff",
        "link":"382F2E",
        "color":"999999",
        "bgItem":"ffffff",
        "title":"222222"
    }
    </script>
</head>
<body paddingwidth="0" paddingheight="0" style="background-repeat: repeat; padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; margin: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; width: 100%;background: #edf2f7;" offset="0" toppadding="0" leftpadding="0">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent" align="center" style="font-family:Helvetica, Arial,serif;">
    <tbody>
    <tr><td height="25"></td></tr>
    <tr>
        <td>
            <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff" class="MainContainer"
                   style="box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);">
                <tbody>
                <tr><td height="25"></td></tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td valign="top" width="40">&nbsp;</td>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td class="movableContentContainer " valign="top">
                                                <div class="movableContent" style="margin: 0; border: 0px; padding-top: 0px; position: relative;padding-bottom:10px;">
                                                    @include("components.mail.header")
                                                </div>
                                                <div class="movableContent" style="margin: 0; border: 0px; padding-top: 0px; position: relative;padding:25px;border:1px solid #dfe3e8">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                                        <tr>
                                                            <td align="left">
                                                                <div class="contentEditableContainer contentTextEditable" style="margin: 0;">
                                                                    <div class="contentEditable" style="margin: 0;font-size:15px">
                                                                        {!!html_entity_decode($data['text'])!!}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        @if(isset($data['url']))
                                                            <tr><td height="30"></td></tr>
                                                            <tr>
                                                                <td align="center">
                                                                    <table>
                                                                        <tr>
                                                                            <td align="center" bgcolor="#289CDC" style="background:#32a506; padding:15px 18px;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 0px;">
                                                                                <div class="contentEditableContainer contentTextEditable" style="margin: 0;">
                                                                                    <div class="contentEditable" align="center" style="margin: 0;">
                                                                                        <a target="_blank" href="{{$data['url']}}" class="link2" style="font-size: 16px; text-decoration: none; color: #ffffff;border-radius:0px;">Click Here</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr><td height="30" style="border-bottom:1px solid #dfe3e8;"></td></tr>
                                                            <tr>
                                                                <td height="20" style="font-size:12px;padding-top:15px;line-height:20px;">
                                                                    If you’re having trouble clicking the "Click Here" button, copy and paste the URL below into your web browser:
                                                                    <a href="{{$data['url']}}">{{$data['url']}}</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                                <!-- =============================== footer ====================================== -->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top" width="20">&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr><td height="25"></td></tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
    @include('components.mail.footer')
</body>
</html>

