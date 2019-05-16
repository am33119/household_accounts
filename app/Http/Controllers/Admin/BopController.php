<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Bop;
use App\Category;
use \DateTime;

class BopController extends Controller
{
  // 該当月の収支合計
  public function add(Request $request)
  {
    // URLパラメータから月取得
    // 2019-03とかの形式を想定
    $month = $request->get('month');
    // dd($month); laravel特有の確認方法
    // var_dump($month);
    // die; (var_dumpはreturnまで全て確認するのでここまでという意味でdie)

    // $last_date = date('t', strtotime($month . '-01'));
    if (is_null($month)) {
      $month = (new DateTime())->format('Y-m');
    }

    // 前・今月・次
    $thisMonth = new DateTime($month);
    $thisMonthStr = $thisMonth->format('Y-m-01 00:00:00');
    $nextMonth = (new DateTime($month))->modify('+1 months');
    $nextMonthStr = $nextMonth->format('Y-m-01 00:00:00');

    $bops = Bop::where('ha_date', '>=', $thisMonthStr )
    ->where('ha_date', '<', $nextMonthStr)
    ->where('user_id', Auth::user()->id)
    ->get();
    //dd($bops);
    //$bop = Bop::all();
    $spending = 0;
    $income = 0;
    foreach ($bops as $bop) {
      if ($bop->category->balance == 1){
        $spending += $bop->amount;
      } elseif ($bop->category->balance == 0){
        $income += $bop->amount;
      }
    }
    //dd($income);

    return view('admin.bop.create',['bops' => $bops, 'month' => $month, 'thisMonth' => $thisMonth, 'income' => $income, 'spending' => $spending, 'user_id' => Auth::user()->id]);
  }



  // 収支のを入力
  public function create(Request $request)
  {
    \Debugbar::error($request);
    // Varidationを行う
    $this->validate($request, Bop::$rules);
    $user = Auth::user();


    // bopはモデルからインスタンス（レコード）を生成するメソッド
    $bop = new Bop;

    //$request->all();でユーザーが入力したデータを取得できる
    $form = $request->all();

    // フォームから送信されてきた_tokenを削除する
    unset($form['_token']);
    unset($form['balance']);

    // データベースに保存する
    $bop->fill($form);
    $bop->save();

    return redirect('/admin/bop/create');
  }


  // 家計簿の編集画面
  public function edit(Request $request)
  {
    $user = Auth::user();
    //Bop Modelからデータを取得する
    $bop = Bop::find($request->id);

    if (empty($bop)) {
      abort(404);
    }
    \Debugbar::error($bop);
    return view('admin.bop.edit', ['bop_form' => $bop, 'user_id' => $user->id]);
  }

  //
  public function update(Request $request)
  {
    // dd($request->bop_text);
    // Validationをかける
    $this->validate($request, Bop::$rules);
    $user = Auth::user();

    // dd($request->id);
    // Bop Modelからデータを取得する
    $bop = Bop::find($request->bop_id);

    // 送信されてきたフォームデータを格納する
    $bop_form = $request->all();

    unset($bop_form['_token']);
    unset($bop_form['remove']);
    unset($bop_form['balance']);
    unset($bop_form['bop_id']);

    // 該当するデータを上書きして保存する
    $bop->fill($bop_form)->save();

    return redirect('admin/bop/create');
  }


  // 1ヶ月の支出のページ
  public function showExpense(Request $request)
  {

    // 金額の合計と必要なカラムを抜き出す
    //$sum_amount = DB::table('bops')->sum('amount');
    //$bops = DB::table('bops')
    //->select(DB::raw('count(*) as user_count, status'))
    //->groupBy('category_id')
    //->get();

    //$pies = Bops::where("user_id",Auth::user()->id)->get();


    // URLの指定
    $month = $request->get('month');

    // もし月の設定がなかったら、今月を表示する
    if (is_null($month)) {
      $month = (new DateTime())->format('Y-m');
    }

    // 1ヶ月を定義
    $thisMonth = new DateTime($month);
    $thisMonthStr = $thisMonth->format('Y-m-01 00:00:00');
    $nextMonth = (new DateTime($month))->modify('+1 months');
    $nextMonthStr = $nextMonth->format('Y-m-01 00:00:00');

    // カテゴリーとその合計を表示する
    $bops_month_spend = DB::table('bops')
    ->join('categories', 'bops.category_id', '=', 'categories.id')
    ->where('balance',1)
    ->where('bops.user_id', Auth::user()->id)
    ->select(DB::raw('sum(amount) as month_amount, categories.category'))
    ->groupBy('category_id', 'categories.category')
    ->where('ha_date', '>=', $thisMonthStr )
    ->where('ha_date', '<', $nextMonthStr)
    ->get();

    // グラフ作成のために配列を作りデータを呼び出す,支出と収入を分ける(収入は別のページへ…)
    $category_list_spend = [];
    $amount_list_spend = [];
    foreach ($bops_month_spend as $bops) {
      $category_list_spend[] = $bops->category;
      $amount_list_spend[] = $bops->month_amount;
    }
    // dd($category_list_spend);
    // dd($category_list);
    return view('admin.bop.expense', [
      'bops_month_spend' => $bops_month_spend,
      'thisMonth' => $thisMonth,
      'categoryList_spend' => $category_list_spend,
      'amountList_spend' => $amount_list_spend,
    ]);
  }


  // 1ヶ月の収入のページ
  public function showIncome(Request $request)
  {
    // URLパラメータから月取得 URLの後に月が表示される
    $month = $request->get('month');

    // もし月の設定がなかったら、今月を表示する
    if (is_null($month)) {
      $month = (new DateTime())->format('Y-m');
    }

    // 1ヶ月を定義
    $thisMonth = new DateTime($month);
    $thisMonthStr = $thisMonth->format('Y-m-01 00:00:00');
    $nextMonth = (new DateTime($month))->modify('+1 months');
    $nextMonthStr = $nextMonth->format('Y-m-01 00:00:00');

    $bops_month_income = DB::table('bops')
    ->join('categories', 'bops.category_id', '=', 'categories.id')
    ->select(DB::raw('sum(amount) as month_amount, categories.category'))
    ->groupBy('category_id', 'categories.category')
    ->where('ha_date', '>=', $thisMonthStr )
    ->where('ha_date', '<', $nextMonthStr)
    ->where('balance',0)
    ->where('bops.user_id', Auth::user()->id)
    ->get();

    $category_list_income = [];
    $amount_list_income = [];

    foreach ($bops_month_income as $bops) {
      $category_list_income[] = $bops->category;
      $amount_list_income[] = $bops->month_amount;
    }

    return view('admin.bop.income', [
      'bops_month_income' => $bops_month_income,
      'thisMonth' => $thisMonth,
      'categoryList_income' => $category_list_income,
      'amountList_income' => $amount_list_income
    ]);
  }

  //月ごとの合計
  public function showTotal(Request $request)
  {
    // 1月から12月まで
    $numbers=[1,2,3,4,5,6,7,8,9,10,11,12];
    // ループさせた収支を代入するため
    $incomes=[];
    $spendings=[];

    // URLパラメーターから年を取得
    $year = $request->get('year');
    //
    if (is_null($year)) {
      $year = (new DateTime())->format('Y');
      $yearStr = (new DateTime())->format('Y-01');
    } else {
      $yearStr = $year . "-01";
    }

    $thisYear = new DateTime($yearStr);

    // 1~12月の月ごとの合計をだす
    foreach ($numbers as $num) {
      // 1ヶ月を定義
      $thisMonth = new DateTime($year.'-'.$num);
      $thisMonthStr = $thisMonth->format('Y-m-01 00:00:00');
      $nextMonthStr = $thisMonth->modify('+1 months')->format('Y-m-01 00:00:00');
      $bops = Bop::where('ha_date', '>=', $thisMonthStr )
      ->where('ha_date', '<', $nextMonthStr)
      ->where('user_id', Auth::user()->id)
      ->get();

      // バランス１（支出）の時とバランス０（収入）の時それぞれの合計
      $spending = 0;
      $income = 0;
      foreach ($bops as $bop) {
        if ($bop->category->balance == 1){
          $spending += $bop->amount;
        } elseif ($bop->category->balance == 0){
          $income += $bop->amount;
        }
      }
      array_push($incomes,$income);
      array_push($spendings,$spending);
    }
    //dd($incomes);
    // $month = $request->get('month');
    // $thisMonth = new DateTime($month);
    // $thisMonthStr = $thisMonth->format('Y-m-01 00:00:00');
    // $nextMonth = (new DateTime($month))->modify('+1 months');
    // $nextMonthStr = $nextMonth->format('Y-m-01 00:00:00');


    // カテゴリーとその合計を表示する
    //         $bops_month_spend = DB::table('bops')
    //                       ->join('categories', 'bops.category_id', '=', 'categories.id')
    //                       ->where('balance',1)
    //                       ->where('bops.user_id', Auth::user()->id)
    //                       ->select(DB::raw('sum(amount) as month_amount, categories.category'))
    //                       ->groupBy('category_id')
    //                       ->where('ha_date', '>=', $thisMonthStr )
    //                       ->where('ha_date', '<', $nextMonthStr)
    //                       ->get();
    // //dd($bops_month_spend);
    //         $category_list_spend = [];
    //         $amount_list_spend = [];
    //         foreach ($bops_month_spend as $bops) {
    //             $category_list_spend[] = $bops->category;
    //             $amount_list_spend[] = $bops->month_amount;
    //         }
    //
    //         // グラフ作成のために配列を作りデータを呼び出す,支出と収入を分ける(収入は別のページへ…)
    //         $category_list_spend = [];
    //         $amount_list_spend = [];
    //         foreach ($bops_month_spend as $bops) {
    //             $category_list_spend[] = $bops->category;
    //             $amount_list_spend[] = $bops->month_amount;
    //         }
    //
    //         $bops_month_income = DB::table('bops')
    //                       ->join('categories', 'bops.category_id', '=', 'categories.id')
    //                       ->select(DB::raw('sum(amount) as month_amount, categories.category'))
    //                       ->groupBy('category_id')
    //                       ->where('ha_date', '>=', $thisMonthStr )
    //                       ->where('ha_date', '<', $nextMonthStr)
    //                       ->where('balance',0)
    //                       ->where('bops.user_id', Auth::user()->id)
    //                       ->get();
    //
    //         $category_list_income = [];
    //         $amount_list_income = [];
    //
    //         foreach ($bops_month_income as $bops) {
    //             $category_list_income[] = $bops->category;
    //             $amount_list_income[] = $bops->month_amount;
    //         }

    //dd($year);

    return view('admin.bop.total', [
      'months' => $numbers,
      'year' => $year,
      'bops' => $bops,
      'thisYear' => $thisYear,
      'incomes'=>$incomes,
      'spendings'=>$spendings,
      //'bops_month_income' => $bops_month_income,
      // 'categoryList_spend' => $category_list_spend,
      // 'amountList_spend' => $amount_list_spend,
      // 'categoryList_income' => $category_list_income,
      // 'amountList_income' => $amount_list_income
    ]);
  }


  // 削除
  public function delete(Request $request)
  {
    // 該当するBop Modelを取得
    $bop = Bop::find($request->id);
    // 削除する
    $bop->delete();
    return redirect('admin/bop/create');
  }


}
