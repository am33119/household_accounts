{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'家計簿'を埋め込む --}}
@section('title', '家計簿')

@section('additional_css')
    <link rel="{{ asset('css/create') }}"/>
@endsection

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>家計簿</h2>
            </div>
        </div>
        <!-- タブ・メニュー -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#ContentA" data-toggle="tab">収支</a></li>
            <li><a href="/admin/bop/expense" data-toggle="tab">今月の支出</a></li>
            <li><a href="#ContentC" data-toggle="tab">年間の支出</a></li>
        </ul>

        <!-- タブ内容 -->
        <div class="tab-content">
            <div class="tab-pane" id="sampleContentA">
                <p>タブＡの内容</p>
            </div>
            <div class="tab-pane active" id="sampleContentB">
                <p>タブＢの内容</p>
            </div>
            <div class="tab-pane" id="sampleContentC">
                <p>タブＣの内容</p>
            </div>
            <div class="tab-pane" id="sampleContentD">
                <p>タブＤの内容</p>
            </div>
        </div>

        <form>
            <div class="form-group">
                <label for="amount">金額</label>
                <input type="amount" class="form-control" id="Inputamount" placeholder="金額を入力して下さい。">
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1"> 収入
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> 支出
                </label>
            </div>
            <div class="form-group">
                <label for="InputSelect">選択</label>
                <select class="form-control" id="InputSelect">
                    <option>選択して下さい</option>
                    <option>食費</option>
                    <option>日用品</option>
                    <option>交通費</option>
                    <option>衣料品</option>
                    <option>娯楽費</option>
                    <option>教育費</option>
                    <option>光熱費</option>
                    <option>通信費</option>
                    <option>医療費</option>
                    <option>保険料</option>
                    <option>家賃・ローン</option>
                    <option>貯蓄</option>
                    <option>その他</option>

                    <option>給料</option>
                    <option>その他</option>
                </select>
            </div>
            <div class="form-group">
                <label for="InputTextarea">メモ</label>
                <textarea class="form-control" id="InputTextarea" placeholder="メモ"></textarea>
            </div>

            <button type="submit" class="btn btn-default">確定</button>
        </form>
    </div>
@endsection
