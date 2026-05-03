<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private static $products = [
    [
        'id' => 1,
        'name' => 'Manual Coffee Grinder',
        'category' => 'Peralatan Kopi',
        'price' => 185000,
        'stock' => 18
    ],
    [
        'id' => 2,
        'name' => 'Vietnam Drip Stainless',
        'category' => 'Peralatan Kopi',
        'price' => 45000,
        'stock' => 35
    ],
    [
        'id' => 3,
        'name' => 'Kopi Arabika Gayo 250gr',
        'category' => 'Biji Kopi',
        'price' => 78000,
        'stock' => 22
    ]
];

    public function index()
    {
        return response()->json([
            'message' => 'Daftar produk berhasil ditampilkan',
            'data' => self::$products
        ], 200);
    }

    public function show($id)
    {
        foreach (self::$products as $product) {
            if ($product['id'] == $id) {
                return response()->json([
                    'message' => 'Detail produk berhasil ditemukan',
                    'data' => $product
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Item dengan ID ' . $id . ' tidak ditemukan'
        ], 404);
    }

    public function store(Request $request)
    {
        if (!$request->name || !$request->category || !$request->price || !$request->stock) {
            return response()->json([
                'message' => 'Data produk tidak lengkap. Field name, category, price, dan stock wajib diisi'
            ], 422);
        }

        $newProduct = [
            'id' => count(self::$products) + 1,
            'name' => $request->name,
            'category' => $request->category,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock
        ];

        self::$products[] = $newProduct;

        return response()->json([
            'message' => 'Produk baru berhasil ditambahkan',
            'data' => $newProduct
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if (!$request->name || !$request->category || !$request->price || !$request->stock) {
            return response()->json([
                'message' => 'Data produk tidak lengkap. PUT harus mengirim name, category, price, dan stock'
            ], 422);
        }

        foreach (self::$products as $index => $product) {
            if ($product['id'] == $id) {
                self::$products[$index] = [
                    'id' => (int) $id,
                    'name' => $request->name,
                    'category' => $request->category,
                    'price' => (int) $request->price,
                    'stock' => (int) $request->stock
                ];

                return response()->json([
                    'message' => 'Seluruh data produk berhasil diperbarui',
                    'data' => self::$products[$index]
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Item dengan ID ' . $id . ' tidak ditemukan'
        ], 404);
    }

    public function patch(Request $request, $id)
    {
        foreach (self::$products as $index => $product) {
            if ($product['id'] == $id) {
                if ($request->has('name')) {
                    self::$products[$index]['name'] = $request->name;
                }

                if ($request->has('category')) {
                    self::$products[$index]['category'] = $request->category;
                }

                if ($request->has('price')) {
                    self::$products[$index]['price'] = (int) $request->price;
                }

                if ($request->has('stock')) {
                    self::$products[$index]['stock'] = (int) $request->stock;
                }

                return response()->json([
                    'message' => 'Sebagian data produk berhasil diperbarui',
                    'data' => self::$products[$index]
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Item dengan ID ' . $id . ' tidak ditemukan'
        ], 404);
    }

    public function destroy($id)
    {
        foreach (self::$products as $index => $product) {
            if ($product['id'] == $id) {
                $deletedProduct = $product;

                unset(self::$products[$index]);

                return response()->json([
                    'message' => 'Produk berhasil dihapus',
                    'data' => $deletedProduct
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Item dengan ID ' . $id . ' tidak ditemukan'
        ], 404);
    }
}