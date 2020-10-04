<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartHasProducts;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addProduct(Request $request, Cart $cart = null){

        $validator = Validator::make($request->all(), [
            'product_id' => ['required','integer'],
            //     'quantity' => ['required','integer']
        ]);

        if($validator->fails()){
            return redirect()->route('order.create')
                            ->withErrors($validator)
                            ->with(['cart' => $cart,
                            'products' => Product::all()]);
        }

        if($cart === null){
            $cart = new Cart();
            $cart->user_id = User::find(    Auth::user()->id  )->first()->id;
            $cart->save();
        }

        //1. se já tem item adicionado no carrinho... 
        $new_item = CartHasProducts::where('product_id','=',$request->product_id)->where('cart_id','=',$cart->id)->first();
    
        if($new_item ===null){
            $new_item = new CartHasProducts();
        }
    
        $new_item->cart_id = $cart->id;
        $new_item->product_id = $request->product_id;
        //2. ... Atribui a quantidade
        $new_item->quantity = $request->quantity;

        $new_item->save();

            return redirect()->route('order.create')
                    ->with(['cart' => $cart,
                    'products' => Product::all()]);
    }

    public function removeProduct(Request $request, CartHasProducts $cartHasProducts){
        $cart = $cartHasProducts->Cart()->first();
        $cartHasProducts->delete();

        return redirect()->route('order.create')
                                ->with(['cart' => $cart,
                                'products' => Product::all()]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}