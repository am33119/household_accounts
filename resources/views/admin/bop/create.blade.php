{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'家計簿'を埋め込む --}}
@section('title', '家計簿')

{{-- public/css/create.cssを読み込む --}}
@section('additional_css')
<link rel="{{ asset('css/create') }}"/>
@endsection


{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <p>【 今日の収支 】</p>



      <!-- カレンダー挿入 -->

      <!-- 入力フォーム -->
      @if (count($errors) > 0)
      <ul>
        @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
      </ul>
      @endif

      <form class="form-horizontal" action="{{ action('Admin\BopController@create') }}" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" required>
        </div>
        <div class="form-group">
          <label for="ha_date">日付</label>

            <input type="date" class="form-control" name="ha_date" id="Inputamount" required>

        </div>
        <div class="form-group">
          <label for="amount">金額</label>
            <input type="amount" class="form-control" name="amount" id="Inputamount" pattern="\d*" oncopy="return false" onpaste="return false" oninput="check_numtype(this)" onblur="check_code(this)" style="ime-mode:disabled" placeholder="金額を入力して下さい。(半角数字のみ)" required>円
          </div>
          <div class="form-group" name="radio">

            <label class="radio-inline">
              <input type="radio" id="inlineRadio1" name="balance" value="収入" required> 収入
            </label>
            <label class="radio-inline">
              <input type="radio" id="inlineRadio2" name="balance" value="支出" required> 支出
            </label>
          </div>

          <div class="form-group">
            <label for="InputSelect">カテゴリー</label>

            <select class="form-control" id="InputSelect" name="category_id" required>
              <option value="">--選択してください--</option>

                @foreach (Auth::user()->categories->where("balance", 0) as $category)
                <option value="{{intval($category->id)}}" class="income_area">{{$category->category}}</option>
                @endforeach

                @foreach (Auth::user()->categories->where("balance", 1) as $category)
                <option value="{{intval($category->id)}}" class="payment_area">{{$category->category}}</option>
                @endforeach
              
            </select>

            {{ csrf_field() }}
          </div>

          <div class="form-group">
            <label for="InputTextarea">メモ</label>

            <textarea class="form-control" id="InputTextarea" name="memo" placeholder="メモ"></textarea>

          </div>
          {{ csrf_field() }}
          <button type="submit" class="btn btn-primary btn-lg">保存</button>

        </form>







      </div>
    </div>
  </div>


  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <table class="tabel">

          <div class="header_label">
            <a href="{{ action('Admin\BopController@add', ['month' => $thisMonth->modify('-1 months')->format('Y-m')]) }}">《 前</a>
            <a href="">{{ $thisMonth->modify('+1 months')->format('Y-m') }}</a>
            <a href="{{ action('Admin\BopController@add', ['month' => $thisMonth->modify('+1 months')->format('Y-m')]) }}">次 》</a>
          </div>
          <p>【 月別収支 】</p>

          <thead>
            <tr>
              <th width="20%">収入</th>
              <th width="25%"></th>
              <th width="20%">支出</th>
              <th width="25%"></th>
              <th width="20%">残高</th>
            </tr>
          </thead>

          <tbody>

            <tr class="{{ action('Admin\BopController@add', ['month' => $thisMonth]) }}">

              <th><h3>{{ $income }}</h3></th>
              <th><h3>-</h3></th>
              <th><h3>{{ $spending }}</h3></th>
              <th><h3>=</h3></th>
              <th><h3>{{ $income - $spending }}</h3></th>


            </tr>
          </tbody>
        </table>
        <p>【 内訳 】</p>

        <table class="table table-striped">
          <thead>
            <tr>
              <th width="20%">日付</th>
              <th width="10%">収支</th>
              <th width="20%">カテゴリー</th>
              <th width="18%">メモ</th>
              <th width="13%">金額</th>
              <th width="13%">編集</th>
              <th width="12%">削除</th>
            </tr>
          </thead>
          <tbody>
            @foreach($bops->sortBy('ha_date') as $bop)
            <tr>
              <td>{{ str_limit($bop->ha_date) }}</td>
              <td>{{ str_limit($bop->category->balance) }}</td>
              <td>{{ str_limit($bop->category->category) }}</td>
              <td>{{ str_limit($bop->memo) }}</td>
              <td>{{ str_limit($bop->amount) }}</td>
              <td>
                <a href="{{ action('Admin\BopController@edit', ['id' => $bop->id]) }}" class="btn btn-primary btn-sm">編集</a>
              </td>
              <td>
                <form action="{{ action('Admin\BopController@delete', ['id' => $bop->id]) }}" method="POST">
                  {{ csrf_field() }}
                  <input type="submit" value="削除" class="btn btn-danger btn-sm btn-dell">
                </form>
              </td>
            </tr>

            @endforeach
          </tbody>
        </table>

      </div>
    </div>

  </div>



  <!-- 収入・支出をどちらかを選択すると収入か支出一方のカテゴリーのみ表示 -->
  <script type="text/javascript">
  $(function(){
    $("input[name='balance']").change(function(){
      // console.log('test');
      // console.log('$(this).val()', $(this).val());

      if ($(this).val() == "収入"){
        $(".payment_area").css("display","none");
        $(".income_area").css("display","block");
      }else{
        $(".income_area").css("display","none");
        $(".payment_area").css("display","block");
      }
    });
  });
  </script>



  <!-- 半角数字 -->
  <script>
    // １．グローバル変数（一時的に保存しておく）を宣言
    var _return_value = "";
    // 入力値の半角数字チェック
    function check_numtype(obj){
      // ２．変数の定義
      var txt_obj = $(obj).val();
      var text_length = txt_obj.length;
      // ３．入力した文字が半角数字かどうかチェック
      if(txt_obj.match(/^[0-9]+$/)){
        // ３．１．文字数チェック
        if(text_length > 9){
          $('input[name="amount"]').val(_return_value);
        }else{
          _return_value = txt_obj;
        }
      }else{
        // ３．２．入力した文字が半角数字ではないとき
        if(text_length == 0){
          $('input[name="amount"]').val("");
          _return_value = "";
        }else{
          $('input[name="amount"]').val(_return_value);
        }
      }
    }
  </script>

  <!-- 削除する時に出るアラート -->
  <script>
  $(function(){
    //console.log('test');  (←JSの確認方法)
    $(".btn-dell").click(function(){
      if(confirm("本当に削除しますか？")){
        //そのままsubmit（削除）
      }else{
        //cancel
        return false;
      }
    });
  });
  </script>



  @endsection
