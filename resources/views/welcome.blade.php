@extends('layouts.app')

@section('title', 'Clientes')

{{--@section('route', route('cliente'))--}}

@section('style_content')

    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/gauge.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <style>
        div.body.chart > div {
            width: 100%;
        }

    </style>
@endsection

@section('page_content')
    <div class="container-fluid">
        <div class="row clearfix">
            {{--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">--}}
                {{--<div class="card">--}}
                    {{--<div class="body chart">--}}
                        {{--<div id="gauge" style="height: 300px"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            @foreach($Page->response as $dashboard)
                <div class="col-lg-{{$dashboard->getSizeDiv()}} col-md-{{$dashboard->getSizeDiv()}} col-sm-{{$dashboard->getSizeDiv()}} col-xs-{{$dashboard->getSizeDiv()}}">
                    <div class="card">
                        <div class="header">
                            <h2><a href="{{route('dashboards.edit',$dashboard->id)}}">{{$dashboard->getSensorName().' - '.$dashboard->getShortName()}}</a></h2>
                        </div>
                        <div class="body chart">
                            <div id="chartdiv[{{$dashboard->id}}]" style="height: {{$dashboard->getSizeStyle()}};"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


@section('script_content')
    <!-- Jquery CountTo Plugin Js -->
    {{--{{Html::script('bower_components/adminbsb-materialdesign/plugins/jquery-countto/jquery.countTo.js')}}--}}
    {{--{{Html::script('bower_components/adminbsb-materialdesign/js/pages/index.js')}}--}}
    <script>
        var $_CHART_ = {};
        var $_AMCHARTS_ = [];

        function setDashboardCilinderAmchart(id, CHART) {
            var chartData = [ {
                "category": "Wine left in the barrel",
                "value1": CHART.data_provider.value,
                "value2": parseFloat(CHART.options.range[1])
            } ];
            var amchart = AmCharts.makeChart(id, {
                "dashboard_id": CHART.options.dashboard_id,
                "sensor_id": CHART.options.sensor_id,
                "timestamp": CHART.options.timestamp,
                "scale": CHART.options.scale,
                "theme": "light",
                "type": "serial",
                "depth3D": 100,
                "angle": 30,
                "autoMargins": false,
                "marginBottom": 100,
                "marginLeft": 350,
                "marginRight": 300,
                "dataProvider": chartData,
                "valueAxes": [ {
                    "stackType": "100%",
                    "gridAlpha": 0
                } ],
                "graphs": [ {
                    "type": "column",
                    "topRadius": 1,
                    "columnWidth": 1,
                    "showOnAxis": true,
                    "lineThickness": 2,
                    "lineAlpha": 0.5,
                    "lineColor": "#FFFFFF",
                    "fillColors": "#8d003b",
                    "fillAlphas": 0.8,
                    "valueField": "value1"
                }, {
                    "type": "column",
                    "topRadius": 1,
                    "columnWidth": 1,
                    "showOnAxis": true,
                    "lineThickness": 2,
                    "lineAlpha": 0.5,
                    "lineColor": "#cdcdcd",
                    "fillColors": "#cdcdcd",
                    "fillAlphas": 0.5,
                    "valueField": "value2"
                }],

                "categoryField": "category",
                "categoryAxis": {
                    "axisAlpha": 0,
                    "labelOffset": 40,
                    "gridAlpha": 0
                }
            } );

            console.log(CHART.options);
            console.log(CHART.data_provider);

            /*
            var chart = AmCharts.makeChart("XXX", {
                "theme": "light",
                "type": "gauge",
                "axes": [{
                    "axisColor": "#31d6ea",
                    "axisThickness": 1,
                    "bandOutlineAlpha": 0,
                    "bands": [{
                        "color": "#0080ff",
                        "endValue": 100,
                        "innerRadius": "105%",
                        "radius": "170%",
                        "gradientRatio": [0.5, 0, -0.5],
                        "startValue": 0
                    }, {
                        "color": "#3cd3a3",
                        "endValue": 0,
                        "innerRadius": "105%",
                        "radius": "170%",
                        "gradientRatio": [0.5, 0, -0.5],
                        "startValue": 0
                    }],
                    "endValue": 100,
                    "endAngle": 90,
                    "gridInside": true,
                    "inside": true,
                    "radius": "50%",
                    "startAngle": -90,
                    "tickColor": "#67b7dc",
                    "topTextFontSize": 20,
                    "topTextYOffset": 70,
                    "unit": "%",
                    "valueInterval": 10,
                }],
                "arrows": [{
                    "alpha": 1,
                    "innerRadius": "35%",
                    "nailRadius": 0,
                    "radius": "170%"
                }]
            });
            var amchart = AmCharts.makeChart(id, {
                "dashboard_id": CHART.options.dashboard_id,
                "sensor_id": CHART.options.sensor_id,
                "timestamp": CHART.options.timestamp,
                "scale": CHART.options.scale,
                "type": "gauge",
                "theme": "light",
                "axes": [{
                    "axisThickness": 1,
                    "axisAlpha": 0.2,
                    "bottomText": CHART.data_provider.value + " " + CHART.options.scale,
                    "bottomTextYOffset": -20,
                    "endValue": parseFloat(CHART.options.range[1]),
                    "startValue": parseFloat(CHART.options.range[0]),
                    "tickAlpha": 0.2
                }],
                "arrows": [ {
                    "value":CHART.data_provider.value
                } ],
            });
            */

            $_AMCHARTS_.push( amchart );

        }

        function setDashboardGaugeAmchart(id, CHART) {
            var amchart = AmCharts.makeChart(id, {
                "dashboard_id": CHART.options.dashboard_id,
                "sensor_id": CHART.options.sensor_id,
                "timestamp": CHART.options.timestamp,
                "scale": CHART.options.scale,
                "theme": "light",
                "type": "gauge",
                "axes": [{
                    "axisColor": "#31d6ea",
                    "axisThickness": 1,
                    "bandOutlineAlpha": 0,
                    "bands": [{
                        "color": "#0080ff",
                        "endValue": parseFloat(CHART.options.range[1]),
                        // "endValue": 1000,
                        "innerRadius": "105%",
                        "radius": "170%",
                        "gradientRatio": [0.5, 0, -0.5],
                        "startValue": parseFloat(CHART.options.range[0])
                        // "startValue": 0
                    }],
                    "bottomText": CHART.data_provider.value + " " + CHART.options.scale,
                    "bottomTextYOffset": -20,
                    "endValue": parseFloat(CHART.options.range[1]),
                    // "endValue": 1000,
                    "endAngle": 90,
                    "gridInside": true,
                    "inside": true,
                    "radius": "50%",
                    // "startValue": parseFloat(CHART.options.range[0]),
                    "startValue": parseFloat(CHART.options.range[0]),
                    "startAngle": -90,
                    // "tickAlpha": 0.2,
                    "tickColor": "#67b7dc",
                    // "topTextFontSize": 20,
                    // "topTextYOffset": 70,
                    "unit": CHART.options.scale,
                    // "valueInterval": 10,
                }],
                "arrows": [{
                    // "value":15,
                    "value":CHART.data_provider.value,
                    "alpha": 1,
                    "innerRadius": "0%",
                    "nailRadius": 0,
                    "radius": "170%"
                }]
            });
            console.log(CHART.options);

            /*
            var chart = AmCharts.makeChart("XXX", {
                "theme": "light",
                "type": "gauge",
                "axes": [{
                    "axisColor": "#31d6ea",
                    "axisThickness": 1,
                    "bandOutlineAlpha": 0,
                    "bands": [{
                        "color": "#0080ff",
                        "endValue": 100,
                        "innerRadius": "105%",
                        "radius": "170%",
                        "gradientRatio": [0.5, 0, -0.5],
                        "startValue": 0
                    }, {
                        "color": "#3cd3a3",
                        "endValue": 0,
                        "innerRadius": "105%",
                        "radius": "170%",
                        "gradientRatio": [0.5, 0, -0.5],
                        "startValue": 0
                    }],
                    "endValue": 100,
                    "endAngle": 90,
                    "gridInside": true,
                    "inside": true,
                    "radius": "50%",
                    "startAngle": -90,
                    "tickColor": "#67b7dc",
                    "topTextFontSize": 20,
                    "topTextYOffset": 70,
                    "unit": "%",
                    "valueInterval": 10,
                }],
                "arrows": [{
                    "alpha": 1,
                    "innerRadius": "35%",
                    "nailRadius": 0,
                    "radius": "170%"
                }]
            });
            var amchart = AmCharts.makeChart(id, {
                "dashboard_id": CHART.options.dashboard_id,
                "sensor_id": CHART.options.sensor_id,
                "timestamp": CHART.options.timestamp,
                "scale": CHART.options.scale,
                "type": "gauge",
                "theme": "light",
                "axes": [{
                    "axisThickness": 1,
                    "axisAlpha": 0.2,
                    "bottomText": CHART.data_provider.value + " " + CHART.options.scale,
                    "bottomTextYOffset": -20,
                    "endValue": parseFloat(CHART.options.range[1]),
                    "startValue": parseFloat(CHART.options.range[0]),
                    "tickAlpha": 0.2
                }],
                "arrows": [ {
                    "value":CHART.data_provider.value
                } ],
            });
            */

            $_AMCHARTS_.push( amchart );
        }

        function setDashboardAmchart(id, CHART){
            var amchart = AmCharts.makeChart(id, {
                "dashboard_id": CHART.options.dashboard_id,
                "sensor_id": CHART.options.sensor_id,
                "timestamp": CHART.options.timestamp,
                "autoMarginOffset": 20,
                "categoryField": "date",
                "dataProvider": CHART.data_provider,
                "dataDateFormat": "YYYY-MM-DD JJ:NN",
                "type": "serial",
                "theme": "light",

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

            });
            $_AMCHARTS_.push( amchart );
        }


        function setData($chart) {

            var sensor_id = $chart.sensor_id;
            var timestamp = $chart.timestamp;
            $.ajax({
                url: '{{route('ajax.get.sensor-last_data')}}',
                data: {sensor_id: sensor_id, timestamp: timestamp},
                type: 'GET',
                dataType: "json",
                error: function (xhr, textStatus) {
                    console.log('xhr-error: ' + xhr.responseText);
                    console.log('textStatus-error: ' + textStatus);
                },
                success: function (json) {
                    if (json.status) {
                        var message = json.message;

                        // return message;
                        console.log(message);
                        if ($chart.type == "serial") {
                            // add new one at the end
                            $chart.dataProvider.shift();

                            if(message != null) {
                                $chart.dataProvider.push({
                                    date: message.date,
                                    value: message.value
                                });
                                $chart.timestamp = message.timestamp;
                            }

                            $chart.validateData();
                        } else {
                            if(message != null) {
                                if (($chart) && ($chart.arrows) && ($chart.arrows[0]) && ($chart.arrows[0].setValue)) {
                                    $chart.arrows[0].setValue(message.value);
                                    $chart.axes[0].setBottomText(message.value + " " + $chart.scale);
                                    $chart.timestamp = message.timestamp;
                                }
                            }
                        }

                    }
                }
            });
        }

        setInterval( function() {
            $.each($_AMCHARTS_, function( index, $chart ){
                setData($chart);
            })
        }, 59000 );


        $(document).ready(function(){

            @foreach($Page->response as $dashboard)
                $_CHART_.options = JSON.parse('<?php print_r($dashboard->getDataChartOptions()); ?>');
                $_CHART_.data_provider = JSON.parse('<?php print_r($dashboard->getDataChart()); ?>');
                @if($dashboard->isGauge())
                    setDashboardGaugeAmchart("chartdiv[{{$dashboard->id}}]", $_CHART_);
                @elseif($dashboard->isCilinder())
                    setDashboardCilinderAmchart("chartdiv[{{$dashboard->id}}]", $_CHART_);
                @else
                    setDashboardAmchart("chartdiv[{{$dashboard->id}}]", $_CHART_);
                @endif

            @endforeach

        });
    </script>
@endsection