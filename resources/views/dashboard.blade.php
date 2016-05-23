@extends('layouts.master')

@section('content')
	@include('includes.message-block')

	<section class="row new-post">
		<div class="col-md-6 col-md-offset-3">
			<header>
				<h3>What do you have to say?</h3>
			</header>
			<form action="{{route('post.create')}}" method="post">
				<div class="form-group">
					<textarea name="body" id="new-post" cols="30" rows="5" class="form-control" placeholder="Your post"></textarea>
					<button class="btn btn-primary" type="submit">Create post</button>
					<input type="hidden" value="{{ Session::token() }}" name="_token">
				</div>
			</form>
		</div>
	</section>

	<section class="row posts">
		<div class="col-md-6 col-md-offset-3">
			<header>
				<h3>Newsfeed</h3>
			</header>
			@foreach ($posts as $post)
				<article class="post" data-postid="{{ $post->id }}">
					<p>{{  $post->body }}</p>
					<div class="info">
						Posted by {{ $post->user->first_name }} on {{ $post->created_at }}
					</div>
					<div class="interaction">
						<a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'  }}</a> |
						<a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don\'t like this post' : 'Dislike' : 'Dislike'  }}</a>
						@if(Auth::user() == $post->user)
							|
							<a href="#" class="edit">Edit</a> |
							<a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
						@endif
						{{-- OR WE CAN USE THIS
							<a href="{{ url('/deletepost/' . $post->id) }}">Delete</a>
						--}}
					</div>
				</article>
				<br>
			@endforeach
		</div>
	</section>

	<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Edit post</h4>
	      </div>
	      <div class="modal-body">
	      	<form>
		        <div class="form-group">
		        		<label for="post-body">Edit the Post</label>
		        		<textarea name="post-body" id="post-body" class="form-control" rows="5"></textarea>
		        </div>
	      	</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" id="modal-save" class="btn btn-primary">Save changes</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	// Set the token & the url that will be used in our app.js
	var token = '{{ Session::token() }}';
	var urlEdit = '{{ route('edit') }}';
	var urlLike = '{{ route('like') }}';
</script>
@endsection