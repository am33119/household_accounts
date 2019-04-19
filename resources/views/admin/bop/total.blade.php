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
    <div class="row">
      <div class="col-md-6">
        <h3>【 {{ $year }}年収支 】</h3>
        <div class="card">
          <div class="book-markdown">
            <div class="markdown-contents">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th width="30%"></th>
                    <th width="35%">収入</th>
                    <th width="35%">支出</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($months as $month)
                  <tr>
                    <td>{{ $month }}月</td>
                    <td>{{ $incomes[$month-1] }}円</td>
                    <td>{{ $spendings[$month-1] }}円</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <h5><span></span><a href="{{ action('Admin\BopController@showTotal', ['year' => $thisYear->modify('-1 years')->format('Y')]) }}">《 前年</a>
          <span></span>{{ $year }}年<span></span>
          <a href="{{ action('Admin\BopController@showTotal', ['year' => $thisYear->modify('+2 years')->format('Y')]) }}">次年 》</a>
        </h5>
        <br>

        <canvas id="myChart" width="400" height="400"></canvas>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
        <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
          // type: 'line',
          type: 'bar',
          data: {
            labels: @json($months),
            datasets: [
              {
                type: 'line', // 追加
                label: '収入',
                data: @json($incomes),
                borderColor : "rgba(254,97,132,0.8)",
                backgroundColor : "rgba(254,97,132,0.5)",
                fill: false,
              },
              {
                type: 'bar', // 追加
                label: '支出',
                data: @json($spendings),
                borderColor : "rgba(54,164,235,0.8)",
                backgroundColor : "rgba(54,164,235,0.5)",
              },
            ],
          },
          options: {
            scales: {
              yAxes: [{
                display: true,             //表示設定
                scaleLabel: {              //軸ラベル設定
                  display: true,          //表示設定
                  labelString: '金額（円）',  //ラベル
                  fontSize: 12               //フォントサイズ
                },
                ticks: {
                  beginAtZero:true
                }
              }],
              xAxes: [{
                display: true,             //表示設定
                scaleLabel: {              //軸ラベル設定
                  display: true,          //表示設定
                  labelString: '月',  //ラベル
                  fontSize: 12               //フォントサイズ
                },
                ticks: {
                  beginAtZero:true
                }
              }]
            }
          }
        });
        </script>

      </div>
    </div>
  </div>
</div>

@endsection
