@section('additional_js')
  <script>
  $(function(){
    consol.log('test');
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
