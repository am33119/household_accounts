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
    //
    public function add(Request $request)
    {
        // URLパラメータから月取得
        // 2019-03とかの形式を想定
        $month = $request->get('month');
        // dd($month);
        // var_dump($month);
        // die;
        // $last_date = date('t', strtotime($month . '-01'));
        if (is_null($month)) {
          $month = (new DateTime())->format('Y-m');
        }
        $thisMonth = new DateTime($month);
        $thisMonthStr = $thisMonth->format('Y-m-01 00:00:00');
        $nextMonth = (new DateTime($month))->modify('+1 months');
        $nextMonthStr = $nextMonth->format('Y-m-01 00:00:00');
        //dd($nextMonthStr);

        $bops = Bop::where('ha_date', '>=', $thisMonthStr )
            ->where('ha_date', '<', $nextMonthStr)
            ->get();
        //dd($bops);
        //$bop = Bop::all();


        return view('admin.bop.create',['bops' => $bops, 'thisMonth' => $thisMonth]); //画面を
    }

    // 家計簿を入力する
    public function create(Request $request)
    {
        \Debugbar::error($request);
        // Varidationを行う
        $this->validate($request, Bop::$rules);

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
        // Bop Modelからデータを取得する
        $bop = Bop::find($request->id);
        if (empty($bop)) {
          abort(404);
        }
        return view('admin.bop.edit', ['bop_form' => $bop]);
    }


    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Bop::$rules);
        // Bop Modelからデータを取得する
        $bop = Bop::find($request->id);
        // 送信されてきたフォームデータを格納する
        $bop_form = $request->all();
        unset($bop_form['_token']);

        // 該当するデータを上書きして保存する
        $bop->fill($bop_form)->save();

        $category = new Category;
        $category->bop_id = $bop->id;
        $category->edited_at = Carbon::now();
        $category->save();

        return redirect('admin/bop/');
    }



    public function showExpense(Request $request)
    {


        //$sum_amount = DB::table('bops')->sum('amount');
        //$bops = DB::table('bops')
                      //->select(DB::raw('count(*) as user_count, status'))
                      //->groupBy('category_id')
                      //->get();

        $bops = DB::table('bops')
                      ->join('categories', 'bops.category_id', '=', 'categories.id')
                      ->select(DB::raw('sum(amount) as total_amount, categories.category'))
                      ->groupBy('category_id')
                      ->get();
//dd($bops);
        return view('admin.bop.expense', ['bops' => $bops]);
    }

    public function delete(Request $request)
    {
         // 該当するBop Modelを取得
         $bop = Bop::find($request->id);
         // 削除する
         $bop->delete();
         return redirect('admin/bop/create');
     }

  }
