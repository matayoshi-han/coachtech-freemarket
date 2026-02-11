<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    //商品一覧を表示する
    public function index()
    {
        $items = Item::all();
        return view('index', compact('items'));
    }

    //商品詳細を表示する
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('show', compact('item'));
    }
}
