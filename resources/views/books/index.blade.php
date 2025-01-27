@extends('layouts.app')

@section('content')
		<h1 class="mb-10 text-2xl">Books</h1>

		<form class="mb-4 flex items-center space-x-2" method="GET" action="{{ route('books.index') }}">
				<input class="input h-10" name="title" type="text" value="{{ request('title') }}" placeholder="Search">
				<input name="filter" type="hidden" value="{{ request('filter') }}" />
				<button class="btn h-10" type="submit">Search</button>
				<a class="btn h-10" href="{{ route('books.index') }}">Clear</a>
		</form>

		<div class="filter-container mb-4 flex">
				@php
						$filters = [
						    '' => 'Latest',
						    'popular_last_month' => 'Popular Last Month',
						    'popular_last_6months' => 'Popular Last 6 Months',
						    'highest_rated_last_month' => 'Highest Rated Last Month',
						    'highest_rated_last_6months' => 'Highest Rated Last 6 Months',
						];
				@endphp

				@foreach ($filters as $key => $label)
						<a class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}"
								href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}">
								{{ $label }}
						</a>
				@endforeach
		</div>

		<ul>
				@forelse ($books as $book)
						<li class="mb-4">
								<div class="book-item">
										<div class="flex flex-wrap items-center justify-between">
												<div class="w-full flex-grow sm:w-auto">
														<a class="book-title" href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
														<span class="book-author">by {{ $book->author }}</span>
												</div>
												<div>
														<div class="book-rating">
																{{-- {{ $book->reviews_avg_rating ? round($book->reviews_avg_rating, 1) : 'No ratings yet' }} --}}
																<x-star-rating :rating="$book->reviews_avg_rating" />
														</div>
														<div class="book-review-count">
																{{ $book->reviews_count ?? 0 }} {{ Str::plural('review', $book->reviews_count) }}
														</div>
												</div>
										</div>
								</div>
						</li>
				@empty
						<li class="mb-4">
								<div class="empty-book-item">
										<p class="empty-text text-lg font-semibold">No reviews yet</p>
										<a class="reset-link" href="{{ route('books.index') }}">Reset criteria</a>
								</div>
						</li>
				@endforelse
		</ul>
@endsection
