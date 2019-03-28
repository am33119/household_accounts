<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Bop;
use App\Category;

class BopController extends Controller
{
    //
    public function add()
    {

        $categories = Category::all();

        var_dump(Auth::user()->id);

        return view('admin.bop.create',['categories' => $categories]); //画面を
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
        // Bop Modelからデータを取得する
        $bop = Bop::find($request->id);

        //$request->all();でユーザーが入力したデータを取得できる
        $form = $request->all();

        $posts = Bop::all();

        return view('admin.bop.expense', ['posts' => $posts]);
    }

    public function delete(Request $request)
    {
         // 該当するBop Modelを取得
         $bop = Bop::find($request->id);
         // 削除する
         $bop->delete();
         return redirect('admin/bop/');
     }

  }
