@extends('layouts.app')

@section('content')
		<h1 class="mb-10 text-2xl">Add Review for {{ $book->title }}</h1>

		<form method="POST" action="{{ route('books.reviews.store', $book) }}">
				@csrf
				<label for="review">Review</label>
				<textarea class="input @error('review') is-invalid @enderror mb-4" id="review" name="review" required>{{ old('review') }}</textarea>
				@error('review')
						<div class="mt-2 text-sm text-red-500">{{ $message }}</div>
				@enderror

				<label for="rating">Rating</label>

				<select class="input @error('rating') is-invalid @enderror mb-4" id="rating" name="rating" required>
						<option value="">Select a Rating</option>
						@for ($i = 1; $i <= 5; $i++)
								<option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
						@endfor
				</select>
				@error('rating')
						<div class="mt-2 text-sm text-red-500">{{ $message }}</div>
				@enderror

				<button class="btn" type="submit">Add Review</button>
		</form>
@endsection
