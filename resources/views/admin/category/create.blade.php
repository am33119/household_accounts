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
    <div class="col-md-4">
      <h3>【カテゴリー登録】</h3>
      <div class="card">
        <div class="book-markdown">
          <div class="markdown-contents">

            <form action="{{ action('Admin\CategoryController@create') }}" method="post" enctype="multipart/form-data">
              <input type="hidden" name="user_id" value="{{ $user_id }}" required>
              <div class="form-group" name="radio">
                <label class="radio-inline">
                  <input type="radio" id="inlineRadio1" name="balance" value="0" required> 収入
                </label>
                <label class="radio-inline">
                  <input type="radio" id="inlineRadio2" name="balance" value="1" checked required> 支出
                </label>
              </div>
              <div class="form-group">
                <label for="category">カテゴリー</label>
                <input type="text" class="form-control" name="category" id="Inputamount" >
              </div>
              {{ csrf_field() }}
              <button type="submit" class="btn btn-primary btn-lg">保存</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <h3>【カテゴリー一覧】</h3>
      <div class="card">
        <div class="book-markdown">
          <div class="markdown-contents">

      @if (count($errors) > 0)
      <ul>
        @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
      </ul>
      @endif


          <div class="row">
          <div class="col-md-6">

            <!-- if / elseを三項演算子で置き換える if($cond===true){ func1(); }else{ func2(); } -->
            {{-- <p>{{ $category->balance == 0 ? "収入" : "支出" }}：{{ $category->category }}</p> --}}
            <h2>収入：</h2>


            @foreach ($categories as $category)
              @if ($category->balance == 0)
              <table>
              <tr>
                <td>
                {{ $category->category }}
            </td>
              <td>
                  <a href="{{ action('Admin\CategoryController@edit', ['id' => $category->id]) }}" class="btn btn-primary btn-sm">編集</a>
                </td>
              <td>
                  <form action="{{ action('Admin\CategoryController@delete', ['id' => $category->id]) }}" method="POST">
                  {{ csrf_field() }}
                  <input type="submit" value="削除" class="btn btn-danger btn-sm btn-dell">
                </form>
              </td>
            </tr>
          </table>
                <br>
              @endif
            @endforeach

        </div>
          <div class="col-md-6">

            <h2>支出</h2>
            @foreach ($categories as $category)
              @if ($category->balance == 1)
              <table>
              <tr>
                <td>
                {{ $category->category }}
              </td>
                <td>
                  <a href="{{ action('Admin\CategoryController@edit', ['id' => $category->id]) }}" class="btn btn-primary btn-sm input-group-addon">編集</a>
                    </td>
                <td>
                  <form action="{{ action('Admin\CategoryController@delete', ['id' => $category->id]) }}" method="POST">
                  {{ csrf_field() }}
                  <input type="submit" value="削除" class="btn btn-danger btn-sm btn-dell">
                </form>
              </td>
            </tr>
          </table>

                <br>
              @endif
            @endforeach
          </td>
          </div>
        </div>
        </tr>
      </tbody>
    </div>
  </div>
</div>
</div>
  </div>
</div>

<script>
$(function(){
  //console.log('test');
  $(".btn-dell").click(function(){
    if(confirm("全ての項目から削除します。本当に削除しますか？")){
      //そのままsubmit（削除）
    }else{
      //cancel
      return false;
    }
  });
});
</script>

<!-- <div class="update">
<a href="{{ action('Admin\CategoryController@update', ['id' => $category->id]) }}">編集</a>
</div> -->

@endsection
