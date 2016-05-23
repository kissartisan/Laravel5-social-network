<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostController extends Controller
{
	  public function getDashBoard()
    {
    	// Fetch all posts
    	$posts = Post::orderBy('created_at', 'desc')->get();

    	// Make the posts available in the view
    	return view('dashboard', ['posts' => $posts]);
    }


    public function postCreatePost(Request $request)
    {
    	// Validation to be tackled later
    	$this->validate($request, [
    		'body' => 'required|max:1000'
    	]);

    	$post = new Post();
    	$post->body = $request['body'];

    	// Access the user in through the $request injection
    	// Save the post to the currently authenticated user:
    	if ($request->user()->posts()->save($post)) {
    		$message = 'Post was successfully created!';
    	}

    	return redirect()->route('dashboard')->with(compact('message'));
    }

    public function getDeletePost($post_id)
    {
    	// We can also use find:  $post = Post::find($post_id)->first();
    	$post = Post::where('id', $post_id)->first();

    	if (Auth::user() != $post->user) {
    		return redirect()->back();
    	}

    	$post->delete(); // Delete the post

    	return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
    }

    public function postEditPost(Request $request)
    {
    	$this->validate($request, [
    		'body' => 'required'
    	]);

    	$post = Post::find($request['postId']);
    	$post->body = $request['body'];
    	$post->update();

    	return response()->json(['new_body' => $post->body], 200);
    }

    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        // Check the string if it is true then, return a boolean
        $is_like = $request['isLike'] === 'true';
        $update = false;
        // Find the post if it is already liked or disliked by the user
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }

        // Retrieve the authenticated (logged in) user
        $user = Auth::user();
        // Check if the user takes an action to this post
        $like = $user->likes()->where('post_id', $post_id)->first();
        // If the user already did an action (like or dislike) to the post
        if ($like) {
            // Set the variable to access the like column (true or false)
            $already_like = $like->like;
            // Set update to true because we are going to change it
            $update = true;

            // If it is liked and I clicked the like button again
            if ($already_like == $is_like) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }

        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;

        if ($update) {
            $like->update();
        } else {
            $like->save();
        }

        return null;
    }

}
