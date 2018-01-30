<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="{{ asset('js/vue.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/fusioncharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/fusioncharts.charts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/fusioncharts.theme.fint.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vue-fusioncharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vue-fusioncharts.min.js') }}"></script>
</head>
<body>
    <div id="app">
    <fusioncharts
    :type="type"
    :width="width"
    :height="height"
    :dataFormat="dataFormat"
    :dataSource="dataSource"
    ></fusioncharts>
</div>
<script type="text/javascript">
    Vue.use(VueFusionCharts);
    const app = new Vue({
      el: '#app',
      data: {
        type: 'column2d',
        width: '500',
        height: '350',
        dataFormat: 'json',
        dataSource: {!! $getData !!}
      }
    });
</script>
</body>
</html>