<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $review;
    public function __construct(Review $review)
    {
        $this->review = $review;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $review = $this->review->paginate(5);
        $reviewResource = ReviewResource::collection($review)->response()->getData(true);
        return response()->json([
            'data' => $reviewResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $dataCreate = $request->all();
        $review = $this->review->create($dataCreate);
        $reviewResource = new ReviewResource($review);
        return response()->json([
            'data' => $reviewResource,
        ], HttpResponse::HTTP_OK);
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
    public function update(UpdateReviewRequest $request, string $id)
    {
        $review = $this->review->findOrFail($id);
        $dataUpdate = $request->all();
        $review->update($dataUpdate);
        $reviewResource = new ReviewResource($review);
        return response()->json([
            'data' => $reviewResource,
        ], HttpResponse::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = $this->review->where('review_id', $id)->firstOrFail();
        $review->delete();
        $reviewResource = new ReviewResource($review);
        return response()->json([
            'data' => $reviewResource,
        ], HttpResponse::HTTP_OK);
    }
}
