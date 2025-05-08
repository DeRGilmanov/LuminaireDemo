<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem; // Добавлен импорт OrderItem
use App\Models\Transaction; // Добавлен импорт Transaction
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price
        )->associate('App\Models\Product');

        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = strtoupper(trim($request->coupon_code)); // Очистка кода
        if (!empty($coupon_code)) {
            $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));

            $coupon = Coupon::whereRaw('UPPER(code) = ?', [strtoupper(trim($coupon_code))])
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', $subtotal)
                ->first();

            if (!$coupon) {
                return redirect()->back()->with('error', 'Промокод не найден или истёк');
            }

            Session::put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value,
            ]);

            $this->calculateDiscount();
            return redirect()->back()->with('success', 'Промокод успешно применён');
        }

        return redirect()->back()->with('error', 'Неправильный промокод');
    }

    public function calculateDiscount()
    {
        $discount = 0;
        if (Session::has('coupon')) {
            $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
            $coupon = Session::get('coupon');

            if ($coupon['type'] === 'fixed') {
                $discount = floatval($coupon['value']);
            } else {
                $discount = ($subtotal * floatval($coupon['value'])) / 100;
            }

            $subtotalAfterDiscount = $subtotal - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format($discount, 2, '.', ''),
                'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
                'tax' => number_format($taxAfterDiscount, 2, '.', ''),
                'total' => number_format($totalAfterDiscount, 2, '.', ''),
            ]);
        }
    }

    public function remove_coupon_code()
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
            Session::forget('discounts');
            return redirect()->back()->with('success', 'Промокод удалён');
        }
        return redirect()->back()->with('error', 'Промокод не найден');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isDefault', 1)->first();
        return view('checkout', compact('address'));
    }

    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isDefault', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'Россия';
            $address->user_id = $user_id;
            $address->isDefault = true;
            $address->save();
        }

        $this->setAmountforCheckout();

        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            $orderItems = new OrderItem();
            $orderItems->product_id = $item->id;
            $orderItems->order_id = $order->id;
            $orderItems->price = $item->price;
            $orderItems->quantity = $item->qty;
            $orderItems->save();
        }

        if ($request->mode == 'card') {
            // ...existing code for card payment...
        } elseif ($request->mode == 'paypal') {
            // ...existing code for PayPal payment...
        } elseif ($request->mode == 'cod') {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = "pending";
            $transaction->save();
        }

        Cart::instance('cart')->destroy(); // Исправлено: Сart -> Cart
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);
        return redirect()->route('cart.order.confirmation');
    }

    public function setAmountforCheckout()
    {
        if (Cart::instance('cart')->content()->count() <= 0) { // Исправлена проверка количества элементов
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }
    public function order_confirmation()
    {
        if(Session::has('order_id')){

            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));

        }
        return redirect()->route('cart.index');
    }
}

