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
}
