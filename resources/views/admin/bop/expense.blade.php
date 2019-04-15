{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'家計簿'を埋め込む --}}
@section('title', '今月の支出内訳')


@section('additional_css')
    <link rel="{{ asset('css/expense') }}"/>
@endsection

@section('additional_js')
    <link rel="{{ asset('js/expense') }}"/>
@endsection

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <a class="btn btn-info" href="/admin/bop/expense" role="button">支出</a>
      <a class="btn btn-info" href="/admin/bop/income" role="button">収入</a>

      <canvas id="myChart" width="400" height="400"></canvas>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

      <script>
      var ctx = document.getElementById("myChart");
      var labels = @json($categoryList_spend);
      var data = @json($amountList_spend);
      var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            backgroundColor: [
              "#BB5179",
              "#FAFF67",
              "#58A27C",
              "#3C00FF"
            ],
            data: data
          }]

        },
        options: {
          title: {
            display: true,
            text: 'カテゴリー別支出'
          }
        }
      });

      </script>
    </div>

    <div class="col-md-6">
      <div class=header_label>
        <a href="{{ action('Admin\BopController@showExpense', ['month' => $thisMonth->modify('-1 months')->format('Y-m')]) }}">《 前</a>
        <a href="">{{ $thisMonth->modify('+1 months')->format('Y-m') }}</a>
        <a href="{{ action('Admin\BopController@showExpense', ['month' => $thisMonth->modify('+1 months')->format('Y-m')]) }}">次 》</a>
      </div>
      @foreach ($bops_month_spend as $bop)

      <p>{{ $bop->category }}：{{ $bop->month_amount }} 円</p>

      @endforeach
    </div>
  </div>
</div>


@endsection
