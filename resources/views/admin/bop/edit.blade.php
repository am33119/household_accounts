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
          <p>【 今日の収支・編集 】</p>



    <!-- カレンダー挿入 -->

    <!-- 入力フォーム -->
            @if (count($errors) > 0)
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
            @endif

            <form action="{{ action('Admin\BopController@update') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="form-group">
                    <label for="ha_date">日付</label>
                    <input type="date" class="form-control" name="ha_date" id="Inputamount" value='{{ $bop_form->ha_date }}'>
                </div>
                <div class="form-group">
                    <p><label for="amount">金額</label>
                    <input type="amount" class="form-control" name="amount" id="Inputamount" value='{{ $bop_form->amount }}'>円</p>
                </div>
                <div class="form-group" name="radio">

                    <label class="radio-inline">
                        <input type="radio" id="inlineRadio1" name="balance" value="収入" @if($bop_form->category->balance ==0 ) checked @endif> 収入
                    </label>
                    <label class="radio-inline">
                        <input type="radio" id="inlineRadio2" name="balance" value="支出" @if($bop_form->category->balance ==1 ) checked @endif> 支出
                    </label>

                </div>

                <div class="form-group">
                  <label for="InputSelect">カテゴリー</label>
                  <select class="form-control" id="InputSelect" name="category_id" value='{{ $bop_form->category->id }}'>
                    <!--<option value="">--選択してください--</option>-->
                    @foreach (Auth::user()->categories->where("balance", 0) as $category)
                      <option value="{{intval($category->id)}}" class="income_area" @if($bop_form->category_id == $category->id) selected="selected" @endif>{{$category->category}}</option>
                    @endforeach

                    @foreach (Auth::user()->categories->where("balance", 1) as $category)
                      <option value="{{intval($category->id)}}" class="payment_area" @if($bop_form->category_id == $category->id) selected="selected"  @endif>{{$category->category}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                    <label for="InputTextarea" >メモ</label>
                    <textarea class="form-control" id="InputTextarea" name="memo">{{ $bop_form->memo }}</textarea>
                </div>
                    {{ csrf_field() }}

                <input type="hidden" name="bop_id" value="{{ $bop_form->id }}">
                <button type="submit" class="btn btn-primary btn-lg">更新</button>

            </form>







            </div>
        </div>
      </div>





    <!-- 収入・支出をどちらかを選択すると収入か支出一方のカテゴリーのみ表示 -->
    <script type="text/javascript">
    function swich_category() {
      var element = document.getElementById("inlineRadio1");
      if (element.checked){
        $(".payment_area").css("display","none");
        $(".income_area").css("display","block");
      }else{
        $(".income_area").css("display","none");
        $(".payment_area").css("display","block");
      }
    }
    window.onload = function() {
      swich_category();
    }
    $(function(){
      $("input[name='balance']").change(function(){
        // console.log('test');
        // console.log('$(this).val()', $(this).val());
        swich_category();
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
