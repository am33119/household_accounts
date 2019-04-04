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

    @foreach($bops as $bop)

    <div class="container">
        <div class="form-group">
          <label for="amount">
          {{ $bop->category }}
          {{ $bop->total_amount }}
          </label>
        </div>
    </div>




    @endforeach

@endsection
