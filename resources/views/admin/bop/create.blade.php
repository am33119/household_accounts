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
        <div id="calendar">
        </div>

        <form>
            <div class="form-group">
                <label for="date">日付</label>
                <input type="date" class="form-control" id="Inputamount">
            </div>
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
                <label for="InputSelect">カテゴリー</label>
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

            <button type="submit" class="btn btn-primary btn-lg">確定</button>
        </form>


        <div class="bop">
            <h2>収入<a href=""></a>-支出<a href=""></a>=残高<a href=""></a></h2>
        </div>


        <table class="table">
          	<thead>
            		<tr>
              		<th>日付</th>
            			<th>カテゴリー</th>
              		<th>収支</th>
              		<th>金額</th>
              	</tr>
            </thead>
            <tbody>
              	<tr>
              		<td><link href="">3月13日</td>
              		<td><link href="">食費</td>
              		<td><link href="">支出</td>
              		<td><link href="">10,000円</td>
              	</tr>
            </tbody>
        </table>



    </div>

    <script src='locale/ja.js'></script>

    <!-- カレンダーにイベント挿入  操作を出来るようにする -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
        $(function(){
            $('#calendar').fullCalendar({
                events: '/events.json',
                selectable: true,
                selectHelper: true,
                select: function(data) {
                    var str = moment(data).format( 'YYYY/MM/DD' );
                    console.log(str);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay,listMonth'
                },
                timeFormat: 'HH:mm',
                timezone: 'Asia/Tokyo',
                eventLimit: true,
                editable: true,
                slotEventOverlap: true,
                selectable: true,
                selectHelper: true,
                selectMinDistance: 1,
                events: function(start, end, timezone, callback) {
                   // ページロード時に表示するカレンダーデータ取得イベント
                },
                eventClick: function(calEvent, jsEvent, view) {
                   // カレンダーに設定したイベントクリック時のイベント
                },
                dayClick: function(date, jsEvent, view) {
                    // カレンダー空白部分クリック時のイベント
                    location.href="/admin/bop/create/"+date
                },

            });
        });
    </script>

@endsection
