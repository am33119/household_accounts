{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'家計簿'を埋め込む --}}
@section('title', 'カテゴリーの登録')

{{-- public/css/create.cssを読み込む --}}
@section('additional_css')
<link rel="{{ asset('') }}"/>
@endsection

@section('additional_js')
    <link rel="{{ asset('js/category_create') }}"/>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>カテゴリー設定</h2>
                <p>【カテゴリー登録】</p>
            </div>
        </div>
        <form action="{{ action('Admin\CategoryController@update') }}" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="balance">収支</label>
                <select class="" name="balance">
                  <option value="">--選択してください--</option>
                  <option value="0">収入</option>
                  <option value="1">支出</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">カテゴリー</label>
                <input type="text" class="form-control" name="category" id="Inputamount">
            </div>
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                {{ csrf_field() }}
            <button type="submit" class="btn btn-primary btn-lg">保存</button>
        </form>




@endsection