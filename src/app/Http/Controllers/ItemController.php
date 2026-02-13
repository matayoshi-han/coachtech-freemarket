<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;

class ItemController extends Controller
{
    //商品一覧を表示する
    public function index(Request $request)
    {
        //マイリストを表示する場合
        if ($request->query('tag') === 'mylist') {
            if (auth()->check()) {
                $items = Item::whereHas('likes', function ($q) {
                    $q->where('user_id', auth()->id());
                })->get();
            } else {
                $items = collect();
            }
        } else {
            //おすすめ商品を表示する場合
            $items = Item::all();
        }

        return view('index', compact('items'));
    }

    //商品詳細を表示する（カテゴリー、コメントを含む）
    public function show($id)
    {
    $item = Item::with(['categories', 'comments.user'])->findOrFail($id);

    return view('show', compact('item'));
    }

    //いいねを切り替える
    public function toggleLike($id)
    {
    $user_id = auth()->id();
    $like = \App\Models\Like::where('item_id', $id)->where('user_id', $user_id)->first();

    if ($like) {
        $like->delete();
    } else {
        \App\Models\Like::create(['item_id' => $id, 'user_id' => $user_id]);
    }

        return back();
    }

    //コメントを送信する
    public function storeComment(Request $request, $id)
    {
    $request->validate([
        'text' => 'required|max:255',
    ]);

    $item = Item::findOrFail($id);
    $item->comments()->create([
        'comment_text' => $request->text,
        'user_id' => auth()->id(),
    ]);
    return back()->with('message', 'コメントを投稿しました');
    }

    //購入手続きページを表示する
    public function purchase($id)
    {
        $item = Item::findOrFail($id);

        return view('purchase', compact('item'));
    }

    //購入を完了する
    public function storeOrder(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'price' => $item->item_amount,
            'payment_method' => $request->payment_method,
            'shipping_postal_code' => $request->postal_code,
            'shipping_address' => $request->address,
            'shipping_building' => $request->building,
        ]);

        return redirect('/')->with('message', '購入が完了しました');
    }
}
