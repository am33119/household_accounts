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
      <div class="expense-number">
        <div class="header_label">
          <h3>【 支出内訳 】</h3>
        </div>
        <div class="card">
          <div class="book-markdown">
            <div class="markdown-contents">
              <div class="categorty">
                <h5>
                  @foreach ($bops_month_spend as $bop)
                  <p>{{ $bop->category }}：{{ $bop->month_amount }} 円</p>
                  @endforeach
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="expense-graph">
        <h4><span></span><span></span><a class="btn btn-info" href="/admin/bop/income" role="button">収入</a>
        <a class="btn btn-info" href="/admin/bop/expense" role="button">支出</a><span></span><span></span>
        <a href="{{ action('Admin\BopController@showExpense', ['month' => $thisMonth->modify('-1 months')->format('Y-m')]) }}">《 前</a>
        {{ $thisMonth->modify('+1 months')->format('Y-m') }}
        <a href="{{ action('Admin\BopController@showExpense', ['month' => $thisMonth->modify('+1 months')->format('Y-m')]) }}">次 》</a>
      </h4>
      <br>
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
                "#19ff00",
                "#3b00ff",
                "#ff7b00",
                "#7200ff",
                "#ff0087",
                "#fffa00",
                "#00ffe5",
                "#ff000c",
                "#0077ff",
                "#d400ff",

              ],
              data: data
            }]

          },
          options: {
            title: {
              display: true,
              text: 'カテゴリー別支出内訳'
            }
          }
        });

        </script>
      </div>
    </div>
  </div>
</div>


@endsection
