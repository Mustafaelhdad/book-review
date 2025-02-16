<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve the title and filter parameters
        $title = $request->input('title'); // Get the value of 'title', or null if it doesn't exist.
        $filter = $request->input('filter', ''); // Get the value of 'filter', default to an empty string.

        // Build the query
        $books = Book::query()
            ->when($title, fn($query) => $query->title($title)) // Filter by title
            ->withAvg('reviews', 'rating') // Include average rating
            ->withCount('reviews'); // Include review count

        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months(),
            default => $books->latest()->withAvgRating()->withReviewsCount(),
        };

        // Execute the query
        $books = $books->get();

        // $cacheKey = 'books:' . $filter . ':' . $title;
        // $books = cache()->remember($cacheKey, 3600, function () use ($books) {
        //     // dd('this is not from the cache');
        //     return $books->get();
        // });
        // $books = cache()->remember($cacheKey, 3600, fn() => $books->get());

        // Return the view with books data
        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // Retrieve the book with reviews, average rating, and reviews count
        $book = Book::with([
            'reviews' => fn($query) => $query->latest(), // Load reviews sorted by latest
        ])->withAvgRating()
            ->withReviewsCount()
            ->findOrFail($id); // Fetch the book or fail if not found

        // Return the view with the book data
        return view('books.show', ['book' => $book]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
