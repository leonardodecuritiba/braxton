<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon-->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Braxton') }} - @yield('title')</title>

    <!-- Bootstrap Core Css -->
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.css')}}">

    {{--    @include('layouts.inc.head')--}}
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

    <style type="text/css">
        html {
            font-family: sans-serif;
            font-size: 12px;
        }

        body {
            margin: 0;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        th {
            text-align: left;
        }

        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        .table > thead > tr > th {
            vertical-align: bottom;
            border-bottom: 2px solid #ddd;
        }

        .table > caption + thead > tr:first-child > th,
        .table > colgroup + thead > tr:first-child > th,
        .table > thead:first-child > tr:first-child > th,
        .table > caption + thead > tr:first-child > td,
        .table > colgroup + thead > tr:first-child > td,
        .table > thead:first-child > tr:first-child > td {
            border-top: 0;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {
            border: 1px solid #ddd;
        }

        .table-bordered > thead > tr > th,
        .table-bordered > thead > tr > td {
            border-bottom-width: 2px;
        }

        .table-condensed > thead > tr > th,
        .table-condensed > tbody > tr > th,
        .table-condensed > tfoot > tr > th,
        .table-condensed > thead > tr > td,
        .table-condensed > tbody > tr > td,
        .table-condensed > tfoot > tr > td {
            padding: 1px;
        }

        .table td {
            text-align: left;
        }

        .fundo_titulo {
            background-color: #000000;
        }

        .fundo_titulo_2 {
            background-color: #1c1c1c;
        }

        .fundo_titulo_3 {
            background-color: #808080;
        }

        .fundo_titulo > .linha_titulo, .fundo_titulo_2 > .linha_titulo, .fundo_titulo_3 > .linha_titulo {
            color: #ffffff;
            font-weight: bold;
            font-size: 12px;
            text-align: center !important;
        }

        .fundo_titulo > .linha_titulo {
            font-size: 13px !important;
        }

        /*campos*/
        .linha_total > th, .linha_total > td {
            text-align: right !important;
            font-weight: bold;
        }

        .campo {
            font-size: 11px;
            line-height: 0.9;
        }

        .campo > td {
            padding-left: 1px !important;
        }

        .sublinhar {
            border-bottom: 1pt solid black !important;
            overflow: hidden;
        }

        .espaco {
            height: 10px;
        }

        .valor, .assinatura {
            text-align: right !important;
        }

        .row_cabecalho {
            text-align: center !important;
        }
        .assinatura {
            height: 30px;
            vertical-align: bottom !important;
        }

        .page-number:before {
            content: counter(page);
        }

        @page {
            margin: 3em 2.5em 2.5em 2.5em;
        }
    </style>
    <style>
        table.table {
            width	: 1200px;
        }
        div.body.chart > div {
            width	: 1200px;
            height	: 300px;
        }

        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
</head>

<body>
<section class="content">

    <span id="teste-chart"></span>


    <table border="0" class="table table-condensed table-bordered">
        <tr class="fundo_titulo">
            <th class="linha_titulo" colspan="4">Relatório Agendado</th>
        </tr>
        <tr class="campo">
            <td>Nome</td>
            <td>Controladora</td>
            <td>Sensor</td>
            <td>Criado Por</td>
        </tr>
        <tr>
            <td>{{$Report['name']}}</td>
            <td>{{$Report['device']}}</td>
            <td>{{$Report['sensor']}}</td>
            <td>{{$Report['author']}}</td>
        </tr>
        <tr class="campo">
            <td>Tipo</td>
            <td>Intervalo / Resolução</td>
            <td>Início</td>
            <td>Fim</td>
        </tr>
        <tr>
            <td>{{$Report['repetition']}}</td>
            <td>{{$Report['interval_time']}}</td>
            <td>{{$Report['period_start']}}</td>
            <td>{{$Report['period_end']}}</td>
        </tr>


        <tr class="fundo_titulo_3">
            <th class="linha_titulo" colspan="4">Detalhes do Período</th>
        </tr>
        <tr class="campo">
            <td>Indicador</td>
            <td>Mínimo ({{$Report['scale_type']}})</td>
            <td>Máximo ({{$Report['scale_type']}})</td>
            <td>Média ({{$Report['scale_type']}})</td>
        </tr>
        <tr>
            <td>{{$Report['sensor_type']}}</td>
            <td>{{$Data->min}} ({{$Data->min_date}})</td>
            <td>{{$Data->max}} ({{$Data->max_date}})</td>
            <td>{{$Data->avg}}</td>
        </tr>



        <tr>
            <td colspan="4">
                <div class="body chart">
                    <div id="chartdiv">
                    </div>
                </div>
            </td>
        </tr>


    </table>


    {{--{!! Form::open(['route' => 'report-view',--}}
        {{--'target' => '_blank',--}}
        {{--'method' => 'POST']) !!}--}}
        {{--{{Form::hidden('image')}}--}}
        {{--{{Form::hidden('id',$Report['id'])}}--}}

        {{--<div class="align-right">--}}
            {{--<button class="btn btn-lg btn-primary waves-effect" onclick="exportChart();" type="submit">Gerar PDF</button>--}}
        {{--</div>--}}

    {{--{{Form::close()}}--}}
    <button class="btn btn-lg btn-primary no-print" onclick="window.print();" type="submit">Imprimir Relatório</button>
</section>

{{--<!-- Jquery Core Js -->--}}
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

{{--<!-- Bootstrap Core Js -->--}}
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script>
    var $_CHART_ = {};
    var $_AM_CHART_ = {};

    function setDashboardAmchart(id, CHART){
        $_AM_CHART_ = AmCharts.makeChart(id, {
            "autoMarginOffset": 20,
            "categoryField": "date",
            "dataProvider": CHART.data_provider,
            "dataDateFormat": "YYYY-MM-DD JJ:NN",
            "type": "serial",
            "theme": "light",

            "responsive": {
                "enabled": false
            },

            "marginTop": 40,
            "marginRight": 20,
            "marginLeft": 55,
            "mouseWheelZoomEnabled":true,

            "balloon": {
                "borderThickness": 1,
                "shadowAlpha": 0
            },
            "categoryAxis": {
                "gridPosition": "start",
                "gridAlpha": 0,
                "tickPosition": "start",
                "tickLength": 20,
                "dashLength": 1,
                "minorGridEnabled": true,
                "minPeriod": "mm",
                "parseDates": true
            },
            "chartCursor": {
                "categoryBalloonDateFormat": "DD/MM/YYYY JJ:NN",
                "cursorAlpha": 1,
                "cursorColor":CHART.options.color,
                "limitToGraph":"g1",
                // "pan": true,
                "valueLineEnabled": true,
                "valueLineBalloonEnabled": true,
                "valueLineAlpha":0.2,
                "valueZoomable":true,
            },
            "graphs": [{
                "id": "g1",
                "balloon":{
                    "drop":true,
                    "adjustBorderColor":false,
                    "color":"#ffffff"
                },

                "bullet": CHART.options.bullet,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "bulletSize": 5,
                "hideBulletsCount": 60,

                "lineThickness": 2,
                "lineAlpha": 1,
                "lineColor": CHART.options.color,
                "useLineColorForBulletBorder": true,
                "balloonText": "<span style='font-size:12px;'>[[value]] " + CHART.options.scale + "</span>",

                "valueField": "value",
                "fillAlphas": CHART.options.fill,
                "type": CHART.options.format,
            }],
            "valueAxes": [{
                "id": "v1",
                "axisAlpha": 0,
                "position": "left",
                "ignoreAxisWidth":true,
            }],
            "export": {
                "enabled": true,
                "menu": []
            },
            "listeners": [{
                "event": "rendered",
                "method": function(e) {
                    exportChart();
                }
            }]

        });

    }
    function exportChart() {
        $_AM_CHART_["export"].capture({}, function() {

            // SAVE TO PNG
            this.toPNG({}, function(base64) {

                // $('input[name=image]').val(base64);
                // // We have now a Base64-encoded image data
                // // which we can now transfer to server via AJAX
                // jQuery.post("saveimage.php", {
                //     "data": base64
                // })
            });
        });
    }

    $(document).ready(function(){

        $_CHART_.options = JSON.parse('<?php echo $Data->options; ?>');
        $_CHART_.data_provider = JSON.parse('<?php echo $Data->response; ?>');
        setDashboardAmchart("chartdiv", $_CHART_);
    })

    var css = '@page { size: landscape; }',
        head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');

    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet){
        style.styleSheet.cssText = css;
    } else {
        style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);

    // window.print();
</script>
</body>
</html>


