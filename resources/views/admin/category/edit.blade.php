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
      <h4>【カテゴリー編集】</h4>
    </div>
  </div>
  <form action="{{ action('Admin\CategoryController@update') }}" method="post" enctype="multipart/form-data">
    <div class="form-group" name="radio">

      <label class="radio-inline">
        <input type="radio" id="inlineRadio1" name="balance" value="0" @if($category_form->balance == 0 ) checked @endif> 収入
      </label>
      <label class="radio-inline">
        <input type="radio" id="inlineRadio2" name="balance" value="1" @if($category_form->balance == 1 ) checked @endif> 支出
      </label>
    </div>
    <div class="form-group">
      <label for="category">カテゴリー</label>
      <input type="text" class="form-control" name="category" id="Inputamount" value='{{ $category_form->category }}'>
    </div>
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $category_form->id }}">
    <button type="submit" class="btn btn-primary btn-lg">保存</button>
  </form>

  @endsection
