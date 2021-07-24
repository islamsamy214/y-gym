@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-4 col-sm-5">
        <div class="widget widget-tile-2 bg-warning m-b-30">
            <div class="wt-content p-a-20 p-b-50">
                <div class="wt-title">{{ __('site.clients') }}</div>
                <div class="wt-number">{{ $clients_count }}</div>
                <div class="wt-text">{{ __('site.updated_at') }}: {{ now() }}</div>
            </div>
            <div class="wt-icon">
                <i class="zmdi zmdi-accounts"></i>
            </div>
        </div>
        <div class="widget widget-tile-2 bg-primary m-b-30">
            <div class="wt-content p-a-20 p-b-50">
                <div class="wt-title">{{ __('site.articles') }}</div>
                <div class="wt-number">{{ $articles_count }}</div>
                <div class="wt-text">{{ __('site.updated_at') }}: {{ now() }}</div>
            </div>
            <div class="wt-icon">
                <i class="zmdi zmdi-file-text"></i>
            </div>
        </div>

        <div class="widget widget-tile-2 bg-danger m-b-30">
            <div class="wt-content p-a-20 p-b-50">
                <div class="wt-title">{{ __('site.plans') }}</div>
                <div class="wt-number">{{ $plans_count }}</div>
                <div class="wt-text">{{ __('site.updated_at') }}: {{ now() }}</div>
            </div>
            <div class="wt-icon">
                <i class="zmdi zmdi-developer-board"></i>
            </div>

        </div>
    </div>
    <div class="col-md-8 col-sm-7">
      <div class="panel panel-default panel-table">
        <div class="panel-heading">

          <h3 class="panel-title">{{ __('site.recent_clients') }}</h3>
          <div class="panel-subtitle">{{ __('site.this_chart_declare_the_clients_status') }}</div>
        </div>
        <div class="panel-body">
          <div class="clearfix">

            <div class="pull-right m-t-10">
              <span class="m-r-15 pull-left">
                <i class="zmdi zmdi-circle text-primary m-r-5"></i> {{ __('site.clients') }}</span>
              <span class="m-r-15">
                <i class="zmdi zmdi-circle text-danger m-r-5"></i> {{ __('site.subscribers') }}</span>
            </div>
          </div>
        </div>

        <div id="chartContainer" style="height: 360px"></div>

      </div>
    </div>
</div>
<script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        axisX: {
            valueFormatString: "MMM,YY"
        },
        axisY: {
		suffix: ""
	    },
        legend:{
            cursor: "pointer",
            fontSize: 16,
            itemclick: toggleDataSeries
        },
        toolTip:{
            shared: true
        },
        data: [{
            name: "{{ __('site.clients') }}",
            type: "spline",
            dataPoints: [
                @foreach($clients_data as $client_data)
                    { x: new Date({{ ($client_data->year) .','. ($client_data->month-1) }}), y: {{ $client_data->count }} },
                @endforeach
            ]
        },
        {
            name: "{{ __('site.subscribers') }}",
            type: "spline",
            dataPoints: [
                @foreach($subscribers_data as $subscriber_data)
                    { x: new Date({{ ($subscriber_data->year) .','. ($subscriber_data->month-1) }}), y: {{ $subscriber_data->count }} },
                @endforeach
            ]
        }]
    });
    chart.render();

    function toggleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else{
            e.dataSeries.visible = true;
        }
        chart.render();
    }

}
</script>
@endsection
