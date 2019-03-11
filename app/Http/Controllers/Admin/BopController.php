<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BopController extends Controller
{
    //
    public function add()
    {
        return view('admin.bop.create');
    }

    // 家計簿を入力する
    public function create(Request $request)
    {
        // Varidationを行う
        $this->validate($request, Bop::$rules);

        // bopはモデルからインスタンス（レコード）を生成するメソッド
        $bop = new Bop;

        //$request->all();でユーザーが入力したデータを取得できる
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $bop->fill($form);
        $bop->save();

        return redirect('admin/bop/create');
    }

    // 家計簿の編集画面
    public function edit(Request $request)
    {
        // Bop Modelからデータを取得する
        $bop = Bop::find($request->id);

        return view('admin.bop.edit', ['bop_form' => $bop]);
    }

    // 家計簿を更新する
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
        $bop->fill($bop_form);
        $bop->save();

        return redirect('admin/bop/');
    }
}
