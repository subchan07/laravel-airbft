<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Promotion::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lastOrder = Promotion::max('order');
        $promotion = Promotion::create([
            'order' => $lastOrder + 1
        ]);
        return response()->json($promotion);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $priotize = ['Add Image', 'Change Image', 'Move Up', 'Move Down', 'Delete Image'];
        foreach ($priotize as $type) {
            foreach ($request['changedThings'] as $change) {
                if ($change['type'] == $type) {
                    if ($change['type'] == 'Add Image') {
                        $path = $change['file']->store('public/promotion');
                        $promotion = Promotion::where('id', $change['id'])->update(['path' => $path]);
                    } else if ($change['type'] == 'Delete Image') {
                        $promotion = Promotion::where('id', $change['id'])->first();
                        $orderDeleted = $promotion->order;
                        if (Storage::exists($promotion->path)) {
                            Storage::delete($promotion->path);
                        }
                        $promotion->delete();
                        Promotion::where('order', '>', $orderDeleted)->decrement('order');
                    } else if ($change['type'] == 'Move Up') {
                        $promotion = Promotion::where('id', $change['id'])->first();
                        $promotionOrder = $promotion->order;
                        $abovePromotion = Promotion::where('order', $promotionOrder - 1)->first();
                        if ($promotion && $abovePromotion) {
                            $promotion->decrement('order');
                            $abovePromotion->increment('order');
                        }
                    } else if ($change['type'] == 'Move Down') {
                        $promotion = Promotion::where('id', $change['id'])->first();
                        $promotionOrder = $promotion->order;
                        $belowPromotion = Promotion::where('order', $promotionOrder + 1)->first();
                        if ($promotion  && $belowPromotion) {
                            $promotion->increment('order');
                            $belowPromotion->decrement('order');
                        }
                    } else if ($change['type'] == 'Change Image') {
                        $path = $change['file']->store('public/promotion');
                        $promotion = Promotion::where('id', $change['id'])->first();
                        if (Storage::exists($promotion->path)) {
                            Storage::delete($promotion->path);
                        }
                        $promotion->update(['path' => $path]);
                    }
                }
            }
        }

        return response()->json(['message' => 'Successfully Saved'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
