

<div class="mb-3">
    
 <h2><a href="{{ route('posts.show', ['post' => $post->id]) }}" class=" text-dark">{{ $post->title }}</a></h2>
@if ($post->comments_count)

    <p>   {{ $post->comments_count }} comments </p>
@else
No comments yet!
    
@endif
</div>



<div class="mb-3">

    <a href="{{ route('posts.edit',['post'=> $post->id]) }}" class="btn btn-primary">Edit</a>
    <form  class="d-inline" action="{{ route('posts.destroy',['post'=> $post->id ]) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete!!" class="btn btn-primary ">
    </form>
</div>