<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\products;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::with('product')->paginate(20);
        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        $products = products::all();
        return view('admin.offers.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'offer_name' => 'nullable|string|max:255',
            'gift_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = uniqid('offer_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/offers'), $name);
            $data['image_path'] = 'upload/offers/' . $name;
        }

        Offer::create($data);
        return redirect()->route('offer.index')->with('success', 'Offer created');
    }

    public function edit(Offer $offer)
    {
        $products = products::all();
        return view('admin.offers.edit', compact('offer', 'products'));
    }

    public function update(Request $request, Offer $offer)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'offer_name' => 'nullable|string|max:255',
            'gift_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        if ($request->hasFile('image')) {
            if ($offer->image_path && file_exists(public_path($offer->image_path))) {
                @unlink(public_path($offer->image_path));
            }
            $file = $request->file('image');
            $name = uniqid('offer_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/offers'), $name);
            $data['image_path'] = 'upload/offers/' . $name;
        }

        $offer->update($data);
        return redirect()->route('offer.index')->with('success', 'Offer updated');
    }

    public function destroy(Offer $offer)
    {
        if ($offer->image_path && file_exists(public_path($offer->image_path))) {
            @unlink(public_path($offer->image_path));
        }
        $offer->delete();
        return redirect()->route('offer.index')->with('success', 'Offer deleted');
    }
}
