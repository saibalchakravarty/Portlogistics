<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Port Logistics') }}</title>
    </head>
    <style>
        td {
            padding:10px;
        }
    </style> 
</head>
<body style="margin: 0; font-family: 'Source Sans Pro', sans-serif; font-size: 14px;">
    <table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
            <td style=" padding: 20px 0;">
                <div style="max-width: 600px; margin: 0 auto;border: 1px solid #41719c">
                    <table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                        <tbody>
                            <tr>
                                <td>
                                    <table width="100%" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
                                        <tr>
                                            <th style="background:#203464; text-align: center;color: #fff" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
                                                <h3>Challan</h3>
                                            </th>
                                        </tr>
                                    </table>
                                    <table class="column-1-2" width="100%" align="left" style="border-collapse: collapse;border-bottom: 1px solid #213965" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="width:20%" valign="top">
                                                    <h3 style="margin: 0">Challan No:</h3>
                                                    <p style="margin: 0">{{$request['challan_no']}}</p>
                                                </td>

                                                <td style="text-align: center; width:55%" valign="top">
                                                    <h1 style="margin: 0">{{$request['org_name']}}</h1>
                                                    <p>{{$request['org_address']}}</p>
                                                </td>

                                                <td style="width:20%" valign="top">
                                                    <h3 style="margin: 0">{{$request['loaded_at']}} <br>Shift:{{$request['shift_name']}}</h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="column-1-2" width="100%" align="left" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="width:45%" valign="top">
                                                    <h3><strong>Place form: </strong>{{$request['origin']}}</h3>
                                                </td>

                                                <td align="left" style="width:45%" valign="top">
                                                    <h3><strong>Place to: </strong>{{$request['destination']}}</h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="column-1-2" width="100%" align="left" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="width:70%" valign="top">
                                                    <h3><strong>Vessel: </strong>{{$request['vessel_name']}}</h3>
                                                </td>
                                                <td style="width:30%" valign="top"><img src="{{$request['barcode_path']}}" alt="barcode" /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="column-1-2" width="100%" align="left" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="width:45%" valign="top">
                                                    <h3><strong>Cargo: </strong>{{$request['cargo_name']}}</h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="column-1-2" width="100%" align="left" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="width:75%" valign="top">
                                                    <h3 style="margin: 0"><strong>Truck/Dumper No: </strong> {{$request['truck_no']}}</h3>
                                                </td>
                                                <td style="width:20%;border-top: 1px solid #213965;text-align: center" valign="top">
                                                    <h3 style="margin: 0"><strong>Signature</strong></h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>