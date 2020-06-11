<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\User;
use App\Tag;
use Auth;
use Gate;
use DB;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function getIndex()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(2);
        return view('blog.index', ['posts' => $posts]);
    }

    public function getAdminIndex()
    {
        $posts = Post::orderBy('title', 'asc')->get();
        return view('admin.index', ['posts' => $posts]);
    }

    public function getPost($id)
    {
        $post = Post::where('id', $id)->with('likes')->first();
        $users = User::all();
        return view('blog.post', ['post' => $post, 'users' => $users]);
    }

    public function getLikePost($id)
    {
        $post = Post::where('id', $id)->first();
        $savedlike = DB::table('likes')
                        ->where('post_id', '=', $post->id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->get();
        if (count($savedlike) <= 0){
            $like = new Like();
            $like->user_id = Auth::user()->id;
            $post->likes()->save($like);   
        }
        return redirect()->back();
    }

    public function unlikePost($id){
        $like = Like::where('id', $id)->first();
        $like->delete();
        return redirect()->back();
    }

    public function getAdminCreate()
    {
        $tags = Tag::all();
        return view('admin.create', ['tags' => $tags]);
    }

    public function getAdminEdit($id)
    {
        $post = Post::find($id);
        $tags = Tag::all();

        return view('admin.edit', ['post' => $post, 'postId' => $id, 'tags' => $tags]);
    }

    public function postAdminCreate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10',
        ]);

        $user = Auth::user();
        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        // Check if a cover image has been uploaded
        if ($request->hasfile('cover_image')) {
            // Get image file
            $image = $request->file('cover_image');
            // Make an image name based on post title and current timestamp
            $name = str_slug($request->input('title')).'_'.time();
            // Define folder path
            $folder = '/uploads/post_images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $image->move(public_path('storage/uploads/post_images'), $name . "." . $image->getClientOriginalExtension());
            // Set post cover image path in database to filePath if there is one
            $post->cover_image = 'storage'. $filePath;
        }

        $user->posts()->save($post);
        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));

        return redirect()->route('admin.index')->with('info', 'Post created, Title is: ' . $request->input('title'));
    }

    public function postAdminUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = Post::find($request->input('id'));
        if (Gate::denies('manipulate-post', $post)) {
            return redirect()->back();
        }
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
//        $post->tags()->detach();
//        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));
        $post->tags()->sync($request->input('tags') === null ? [] : $request->input('tags'));
        return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' . $request->input('title'));
    }

    public function getAdminDelete($id)
    {
        $post = Post::find($id);
        if (Gate::denies('manipulate-post', $post)) {
            return redirect()->back();
        }

        //TO-DO: Delete the images saved locally as well
        File::delete($post->cover_image);

        $post->likes()->delete();
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('admin.index')->with('info', 'Post deleted!');
    }

    public function storePDF($id){
        $post = Post::find($id);
        $pdf = PDF::loadView('blog.pdf', compact('post'));
        
        return $pdf->download('downloaded_Post.pdf');
    }
}
