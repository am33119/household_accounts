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

    <script type="text/javascript" src="expense.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
    <canvas id="myChart" width="200" height="200"></canvas>




    
    <div class="container">
        <div class="form-group">
          <label for="amount">食費</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">日用品</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">交通費</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">衣料品</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">娯楽費</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">教育費</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">光熱費</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">通信費</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">医療費</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">保険料</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">家賃・ローン</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">貯蓄</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">その他</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>


        <div class="form-group">
          <label for="amount">給料</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
        <div class="form-group">
          <label for="amount">その他</label>
          <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
        </div>
    </div>
@endsection
