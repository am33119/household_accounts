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
        <div class="col-md-6">
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

            <form action="{{ action('Admin\BopController@create') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="form-group">
                    <label for="ha_date">日付</label>
                    <input type="date" class="form-control" name="ha_date" id="Inputamount">
                </div>
                <div class="form-group">
                    <p><label for="amount">金額</label>
                    <input type="amount" class="form-control" name="amount" id="Inputamount" placeholder="金額を入力して下さい。">円</p>
                </div>
                <div class="form-group" name="radio">

                    <label class="radio-inline">
                        <input type="radio" id="inlineRadio1" name="balance" value="収入"> 収入
                    </label>
                    <label class="radio-inline">
                        <input type="radio" id="inlineRadio2" name="balance" value="支出"> 支出
                    </label>
                </div>

                    <div class="form-group">
                        <label for="InputSelect">カテゴリー</label>
                        <select class="form-control" id="InputSelect" name="category_id">
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
        <div class="col-md-6">
          <table class="tabel">

            <div class=header_label>
                <a href="{{ action('Admin\BopController@add', ['month' => $thisMonth->modify('-1 months')->format('Y-m')]) }}">《 前</a>
                <a href="">{{ $thisMonth->modify('+1 months')->format('Y-m') }}</a>
                <a href="{{ action('Admin\BopController@add', ['month' => $thisMonth->modify('+1 months')->format('Y-m')]) }}">次 》</a>
            </div>
            <p>【 月別収支 】</p>

              <thead>
                  <tr>
                      <th>収入</th>
                      <th>-</th>
                      <th>支出</th>
                      <th>=</th>
                      <th>残高</th>
                  </tr>
              </thead>

              <tbody>

                  <tr class="{{ action('Admin\BopController@add', ['month' => $thisMonth]) }}">

                      <th>{{ $income }}</th>
                      <th>-</th>
                      <th>{{ $spending }}</th>
                      <th>=</th>
                      <th>{{ $income - $spending }}</th>


                  </tr>
              </tbody>
          </table>
          <p>【 内訳 】</p>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="20%">日付</th>
                                <th width="5%">収支</th>
                                <th width="20%">カテゴリー</th>
                                <th width="20%">メモ</th>
                                <th width="15%">金額</th>
                                <th width="30%">更新 ／ 削除</th>
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
                                    <div class="update">
                                        <a href="{{ action('Admin\BopController@edit', ['id' => $bop->id]) }}">編集</a>
                                    </div>
                                    <div class="delete">
                                        <a href="{{ action('Admin\BopController@delete', ['id' => $bop->id]) }}">削除</a>
                                    </div>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>

            </div>
        </div>

    </div>



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
    <script>
    var toHankaku = function (strVal){
    // 半角変換
    var halfVal = strVal.replace(/[！-～]/g, function(tmpStr) {
        // 文字コードをシフト
        return String.fromCharCode(tmpStr.charCodeAt(0) - 0xFEE0);
    });

    // 文字コードシフトで対応できない文字の変換
    halfVal = halfVal.replace(/”/g, "\"")
        .replace(/[ｰー―－‐]/, "-")
        .replace(/’/g, "'")
        .replace(/‘/g, "`")
        .replace(/￥/g, "\\")
        .replace(/　/g, " ")
        .replace(/?/g, "~");

    return halfVal;
};

$("input.en").change(function() {
    var $this = $(this);
    $this.val(toHankaku($this.val()));
});
</script>



@endsection
