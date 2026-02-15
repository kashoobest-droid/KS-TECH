<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\Review;
use App\Models\ReviewReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, products $product)
    {
        // Verify that the user has actually purchased this product
        if (!$product->hasPurchasedBy(Auth::user())) {
            return back()->with('error', 'Only verified buyers can leave reviews. Please purchase this product first.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => Auth::id(),
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('review_success', 'Thank you for your review!');
    }

    public function update(Request $request, Review $review)
    {
        // Verify ownership
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'You can only edit your own reviews.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('review_success', 'Your review has been updated!');
    }

    public function destroy(Review $review)
    {
        // Verify ownership
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'You can only delete your own reviews.');
        }

        $review->delete();

        return back()->with('review_success', 'Your review has been deleted!');
    }

    public function react(Request $request, Review $review)
    {
        $request->validate([
            'reaction_type' => 'required|in:helpful,not_helpful',
        ]);

        $reaction_type = $request->reaction_type;

        // Check if user already reacted
        $existingReaction = ReviewReaction::where('review_id', $review->id)
                                        ->where('user_id', Auth::id())
                                        ->first();

        if ($existingReaction) {
            // If clicking the same reaction, remove it
            if ($existingReaction->reaction_type === $reaction_type) {
                $existingReaction->delete();
                return back()->with('review_success', 'Reaction removed!');
            } else {
                // Otherwise, update the reaction
                $existingReaction->update(['reaction_type' => $reaction_type]);
                return back()->with('review_success', 'Reaction updated!');
            }
        } else {
            // Create new reaction
            ReviewReaction::create([
                'review_id' => $review->id,
                'user_id' => Auth::id(),
                'reaction_type' => $reaction_type,
            ]);
            return back()->with('review_success', 'Thank you for your feedback!');
        }
    }
}
