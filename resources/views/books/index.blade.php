@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>

    <form action=""></form>

    <ul>
      @forelse ($books as $book)
        <li class="mb-4">
          <div class="book-item">
            <div
            class="flex flex-wrap items-center justify-between">
              <div class="w-full flex-grow sm:w-auto">
                <a href="{{route('books.show', $book)}}" class="book-title">{{$book->title}}</a>
                <span class="book-author">by {{$book->author}}</span>
              </div>
              <div>
                <div class="book-rating">
                  {{ round($book->reviews_avg_rating, 1) ?? 'No ratings yet' }}
                </div>
                <div class="book-review-count">
                  out of {{ $book->reviews_count ?? 0 }} {{Str::plural('review', $book->reviews_count)}}
                </div>
              </div>
            </div>
            </div>
        </li>
      @empty
        <li class="mb-4">
          <div class="empty-book-item">
            <p class="empty-text text-lg font-semibold">No reviews yet</p>
            <a href="{{route('books.index')}}" class="reset-link">Reset criteria</a>
          </div>
        </li>
      @endforelse
    </ul>
@endsection
