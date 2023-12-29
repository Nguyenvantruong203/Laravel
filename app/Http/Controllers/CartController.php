<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required'
        ]);

        $product = Cart::create($validatedData);
        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ]);
    }

    public function showCart()
    {
        // Tính tổng giá của tất cả sản phẩm trong giỏ hàng
        $totalPrice = Cart::sum('price');

        // Lấy tất cả các sản phẩm trong giỏ hàng
        $products = Cart::all();

        // Trả về dữ liệu dưới dạng JSON kèm theo tổng giá của sản phẩm trong giỏ hàng
        return response()->json([
            'products' => $products,
            'total_price' => $totalPrice,
        ]);
    }


    public function destroy($id)
    {
        $product = Cart::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
