{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'家計簿'を埋め込む --}}
@section('title', '年間の支出内訳')


@section('additional_css')
<link rel="{{ asset('css/total') }}"/>
@endsection

@section('additional_js')
<link rel="{{ asset('js/total') }}"/>
@endsection

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')


<div class="container">
  <div class="form-group">

    <canvas id="myBarChart"></canvas>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

    <script>
    var ctx = document.getElementById("myBarChart");
    var stackedBar = new Chart(ctx, {
      type: 'bar',
      label: @json($months),
      data: @json($incomes),
      options: {
        scales: {
          xAxes: [{
            stacked: true
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }
    });

  </script>

@foreach($months as $month)
  <p>{{$month}}月</p>
  <p>収入： {{ $incomes[$month-1] }}円</p>
  <p>支出： {{ $spendings[$month-1] }}円</p>
@endforeach
</div>
</div>




@endsection
