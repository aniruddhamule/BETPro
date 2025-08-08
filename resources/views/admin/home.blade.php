@extends('admin.layouts.master')
@section('content')

<div class="row gy-4">
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Users')}}</p>
        <h3 class="mb-0">{{@$total_user}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-users"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Verified Users')}}</p>
        <h3 class="mb-0">{{@$total_ver_user}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-user-plus"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Unverified Users')}}</p>
        <h3 class="mb-0">{{@$total_unver_user}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-user-times"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Banned Users')}}</p>
        <h3 class="mb-0">{{$total_bn_user}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-user"></i>
      </div>
    </div>
  </div>
</div>

<div class="row gy-4 mt-3">
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Pridicted Amount')}}</p>
        <h3 class="mb-0">{{@$general->currency_symbol}} {{ number_format(@$pridictionInvest, 2) }}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-wallet"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Refund Amount')}}</p>
        <h3 class="mb-0">{{@$general->currency_symbol}} {{ number_format(@$pridictionRefund, 2) }}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-hand-holding-usd"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Return Amount')}}</p>
        <h3 class="mb-0">{{@$general->currency_symbol}} {{ number_format(@$pridictionReturn, 2) }}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-calendar-check"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Profit From Prediction')}}</p>
        <h3 class="mb-0">{{@$general->currency_symbol}} {{ @$totalProfit }}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-coins"></i>
      </div>
    </div>
  </div>
</div>

<div class="row gy-4 mt-3">
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Deposit')}}</p>
        <h3 class="mb-0">{{@$total_deposit}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-clipboard-list"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Deposit Charge')}}</p>
        <h3 class="mb-0">{{@$total_deposit_crg}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-money-bill"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Pending Deposit')}}</p>
        <h3 class="mb-0">{{@$total_depo_pending}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-money-bill-wave"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('This Month Deposit')}}</p>
        <h3 class="mb-0">{{round(@$total_deposit_month,2)}} {{$general->currency}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-money-bill-wave"></i>
      </div>
    </div>
  </div>
</div>

<div class="row gy-4 mt-3">

  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Withdraw')}}</p>
        <h3 class="mb-0">{{@$total_withdraw}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-coins"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Withdraw Charge')}}</p>
        <h3 class="mb-0">{{@$total_withdraw_crg}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-seedling"></i>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Pending Withdrawals')}}</p>
        <h3 class="mb-0">{{@$total_withdraw_pending}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-hand-holding-usd"></i>
      </div>
    </div>
  </div>

  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('This Month Withdraw')}}</p>
        <h3 class="mb-0">{{round(@$total_withdraw_month,2)}} {{$general->currency}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-hand-holding-usd"></i>
      </div>
    </div>
  </div>
</div>


<div class="row gy-4 mt-3">
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Running Tournament')}}</p>
        <h3 class="mb-0">{{@$runing_turnament}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-spinner"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Running Event')}}</p>
        <h3 class="mb-0">{{@$runningMatches}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-times-circle"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Closed Event')}}</p>
        <h3 class="mb-0">{{@$endMatches}}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-money-bill-wave"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="s7__widget-three">
      <div class="content">
        <p class="mb-2">{{__('Total Charge From Winner')}}</p>
        <h3 class="mb-0">{{@$general->currency_symbol}} {{ number_format(@$betReturnCharge, 2) }}</h3>
      </div>
      <div class="icon s7__bg-primary rounded-circle">
        <i class="las la-hand-holding-usd"></i>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card mt-4">
          <div class="card-body">
              <div id="chart3"></div>
          </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mt-4">
          <div class="card-body">
              <div id="chart"></div>
          </div>
        </div>
    </div>
</div>

<div class="card mt-5">
  <div class="card-header border-0">
      <div class="d-flex flex-wrap justify-content-between align-items-center">
          <h6 class="text-uppercase mb-0">{{__('Latest User')}}</h6>
      </div>
  </div>
  <div class="card-body p-0">
    <table class="table s7__table">
        <thead>
            <tr>
              <th>{{__('Name')}}</th>
              <th>{{__('Email')}}</th>
              <th>{{__('Balance')}}</th>
              <th>{{__('Status')}}</th>
              <th>{{__('Action')}}</th>
            </tr>
        </thead>
        <tbody>
          @foreach($latestUser as $data)
          <tr>
            <td data-caption="customer">
              <div class="content">
                <h6 class="text-small mb-0">@lang($data->name)</h6>
              </div>
            </td>
            <td data-caption="Product">@lang($data->email)</td>
            <td data-caption="Date">{{getAmount($data->balance)}} {{$general->currency}}</td>
            <td data-caption="Status">
              @if($data->status == 1)
                  <span class="s7__badge s7__badge-success">@lang('Active')</span>
              @else
                  <span class="s7__badge s7__badge-danger">@lang('Inactive')</span>
              @endif
            </td>
            <td data-caption="Action">
              <a href="{{route('user.view', $data->id)}}" class="btn s7__btn-secondary btn-sm"><i class="las la-edit"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
  </div>
</div>

@endsection
@section('script')

<script>

var options = {
    series: [{
      name: "Plus Transactions",
      data: [
        @foreach ($report['months'] as $trxDate)
            {{ @$plusTrx->where('months', $trxDate)->first()->amount ?? 0 }},
        @endforeach
      ]
  }, {
    name: 'Minus Transactions',
    data: [
      @foreach ($report['months'] as $trxDate)
          {{ @$minusTrx->where('months', $trxDate)->first()->amount ?? 0 }},
      @endforeach
    ]
  }],
    chart: {
    height: 350,
    type: 'line',
    zoom: {
      enabled: false
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'straight'
  },
  title: {
    text: 'Batting Statistics (Last 12 Month)',
    align: 'left'
  },
  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'],
      opacity: 0.5
    },
  },
  xaxis: {
    categories:  @json($months)
  }
};

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();


  var options = {
      series: [{
      name: 'Total Deposit',
      data: [
        @foreach ($months as $month)
            {{ getAmount(@$depositsMonth->where('months', $month)->first()->depositAmount) }},
        @endforeach
        ]
    }, {
      name: 'Total Withdraw',
      data: [
        @foreach ($months as $month)
            {{ getAmount(@$withdrawalMonth->where('months', $month)->first()->withdrawAmount) }},
        @endforeach
      ]
    }],
      chart: {
      type: 'bar',
      height: 350,
      toolbar: {
          show: false
      }
    },
    title: {
      text: 'Monthly Deposit & Withdraw Report (Last 12 Month)',
      align: 'left'
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: @json($months),
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return "{{ __($general->currency) }} " + val + " "
        }
      }
    }
  };

  var chart3 = new ApexCharts(document.querySelector("#chart3"), options);
  chart3.render();

</script>
@stop
