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
    public function create()
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
    public function edit()
    {
        return view('admin.bop.edit');
    }

    // 家計簿を更新する
    public function update()
    {
        return redirect('admin/bop/edit');
    }
}
