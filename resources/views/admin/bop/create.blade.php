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
            <div class="col-md-8 mx-auto">
                <h2>今日の収支</h2>
            </div>
        </div>

    <!-- カレンダー挿入 -->

    <!-- 入力フォーム -->
    @if (count($errors) > 0)
    <ul>
        @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{ action('Admin\BopController@create') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="form-group">
            <label for="ha_date">日付</label>
            <input type="date" class="form-control" name="ha_date" id="Inputamount">
        </div>
        <div class="form-group">
            <p><label for="amount">金額</label>
            <input type="amount" class="form-control" name="amount" id="Inputamount" placeholder="金額を入力して下さい。">円</p>
        </div>
        <div class="radio">
            <label>
                <input type="radio" id="optionsRadios1" name="balance" value="option1"> 収入
            </label>
            <label>
                <input type="radio" id="optionsRadios2" name="balance" value="option2"> 支出
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


        <div class="bop">
            <h2>収入<a href=""></a>-支出<a href=""></a>=残高<a href=""></a></h2>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <h2>今月の収支</h2>
        </div>



        <div class="row">
            <div class="list-date col-md-12 mx-auto">
                <div class="row">
                    <div class=header_label>
                        <a href="{{ action('Admin\BopController@add', ['month' => $thisMonth->modify('-1 months')->format('Y-m')]) }}">前</a>
                        <a href="{{ action('Admin\BopController@add') }}" >今月</a>
                        <a href="{{ action('Admin\BopController@add', ['month' => $thisMonth->modify('+2 months')->format('Y-m')]) }}">次</a>
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">日付</th>
                                <th width="10%">収支</th>
                                <th width="20%">カテゴリー</th>
                                <th width="20%">メモ</th>
                                <th width="20%">金額</th>
                                <th width="10%">更新 ／ 削除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bops as $bop)

                            <tr>
                                <td>{{ str_limit($bop->ha_date, 50) }}</td>
                                <td>{{ str_limit($bop->category->balance, 50) }}</td>
                                <td>{{ str_limit($bop->category->category, 100) }}</td>
                                <td>{{ str_limit($bop->memo, 100) }}</td>
                                <td>{{ str_limit($bop->amount, 100) }}</td>
                                <td>
                                    <div>
                                        <a href="{{ action('Admin\BopController@edit', ['id' => $bop->id]) }}">編集</a>
                                    </div>
                                    <div>
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
    </div>


    <script type="text/javascript">
    $(function(){
    $("input[name='optionsRadios']").change(function(){
    if ($(this).val()=="option1"){
      $(".payment_area").css("display","none");
      $(".income_area").css("display","block");
    }else{
      $(".income_area").css("display","none");
      $(".payment_area").css("display","block");
    }
    });
    });
    </script>



@endsection
