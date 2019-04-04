<?php

namespace App\Http\Controllers\Admin;
// use App\Http\Controllers\Auth;

use Illuminate\Http\Request;
// use App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    //
    public function add(Request $request)
    {
        //$categories = Category::all();
        $categories = Category::where('Auth::user()->id');
        return view('admin.category.create',['categories' => $categories]); //画面を
    }

    // 家計簿を入力する
    public function create(Request $request)
    {
        // Varidationを行う
        $this->validate($request, Category::$rules);

        // bopはモデルからインスタンス（レコード）を生成するメソッド
        $category = new Category;

        //$request->all();でユーザーが入力したデータを取得できる
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $category->fill($form)->save();

        $categories = Category::all();

        return redirect('/admin/category/create');
    }

    // 家計簿の編集画面
    public function edit(Request $request)
    {
        // Bop Modelからデータを取得する
        $category = Category::find($request->id);

        return view('admin.category.edit', ['category_form' => $category]);
    }

    // 収支を入力する
    public function input(Request $request)
    {
        // Validationをかける
        $this->validate($request, Category::$rules);

        // Bop Modelからデータを取得する
        $bop = Category::find($request->id);

        // 送信されてきたフォームデータを格納する
        $category_form = $request->all();
        unset($category_form['_token']);

        // 該当するデータを上書きして保存する
        $category->fill($category_form);
        $category->save();

        return redirect('/admin/category/create');
    }

    public function showExpense()
    {


        return view('admin.bop.expense');
    }

  }
