<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Charge;

class ItemController extends Controller
{
    //商品一覧を表示する
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $tag = $request->query('tag');

        $query = Item::query();

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('item_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('item_brand', 'LIKE', "%{$keyword}%");
            });
        }

        if ($tag === 'mylist') {
            if (auth()->check()) {
                $query->whereHas('likes', function ($q) {
                    $q->where('user_id', auth()->id());
                });
            } else {
                return view('index', ['items' => collect()]);
            }
        }

        $items = $query->get();
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
    public function storeComment(CommentRequest $request, $id)
    {
    $item = Item::findOrFail($id);

    $item->comments()->create([
        'comment_text' => $request->comment_text,
        'user_id' => auth()->id(),
    ]);
    return back()->with('message', 'コメントを投稿しました');
    }

    //購入手続きページを表示する
    public function purchase($id)
    {
        $item = Item::findOrFail($id);
        $user = auth()->user();

        return view('purchase', compact('item', 'user'));
    }

    //購入を完了する
    public function storeOrder(PurchaseRequest $request, $id)
    {
        $item = Item::findOrFail($id);

        // すでに売却済みかチェック
        if ($item->order) {
            return back()->withErrors(['error' => 'この商品はすでに売り切れです。']);
        }

        // --- Stripe決済処理 ---
        if ($request->payment_method === 'credit_card') {
            try {
                // .envからシークレットキーをセット
                Stripe::setApiKey(env('STRIPE_SECRET'));

                // 決済実行
                Charge::create([
                    'amount' => $item->item_amount,
                    'currency' => 'jpy',
                    'source' => $request->stripeToken, // JSから渡されたトークン
                    'description' => "商品名: {$item->item_name}",
                ]);
            } catch (\Exception $e) {
                // 決済エラー時は購入画面に戻す
                return back()->withErrors(['payment_method' => '決済に失敗しました：' . $e->getMessage()])->withInput();
            }
        }

        // --- DB保存（決済成功、またはコンビニ払い時） ---
        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'price' => $item->item_amount,
            'payment_method' => $request->payment_method,
            'shipping_postal_code' => $request->shipping_postal_code,
            'shipping_address' => $request->shipping_address,
            'shipping_building' => $request->shipping_building,
        ]);

        return redirect('/')->with('message', '購入が完了しました');
    }

    // 住所変更画面を表示
    public function editAddress($id)
    {
        $item = Item::findOrFail($id);
        $user = auth()->user();
        return view('address', compact('item', 'user'));
    }

    // 住所を更新して購入画面に戻る
    public function updateAddress(AddressRequest $request, $id)
    {

        $user = \App\Models\User::find(auth()->id());

        $user->update([
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ]);

        return redirect()->route('items.purchase', ['id' => $id]);
    }

    //出品画面を表示する
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('sell', compact('categories'));
    }

    //出品を保存する
    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('image')->store('items', 'public');

        $imagePath = 'storage/' . $path;

        $item = Item::create([
            'user_id' => auth()->id(),
            'image_url' => $imagePath,
            'item_state' => $request->condition,
            'item_name' => $request->item_name,
            'item_brand' => $request->brand_name,
            'item_description' => $request->item_description,
            'item_amount' => $request->item_amount,
        ]);

        $item->categories()->sync($request->categories);

        return redirect('/')->with('message', '商品を出品しました');
    }


}
