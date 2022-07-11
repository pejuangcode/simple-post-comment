@extends('layouts.post')

@section('content')
    <div class="">

        @include('components.header-post') 
        
        <div class="flex mx-auto items-center justify-center shadow-lg mx-8 mb-4 max-w-lg mt-200">
            <form method="POST" action="{{ route('posts.store') }}" class="w-full max-w-xl bg-white rounded-lg px-4 pt-2">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-6">
                    <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">Add a new post</h2>
                    <div class="w-full md:w-full px-3 mb-2 mt-2">
                        @if (Session::has('success'))
                            <div class="mb-2 text-sm text-green-700 dark:text-green-800" role="alert">
                                {!! \Session::get('success') !!}
                            </div>
                        @endif
                        <textarea name="body" class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"  placeholder='Type Your Post'>{{ old('body') }}</textarea>
                        <input name="user_id" type="hidden" value="{{ auth()->user()->id }}" />
                        @error('body')
                            <div class="mb-2 text-sm text-red-700 dark:text-red-800" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="w-full md:w-full flex items-start md:w-full px-3">
                        <div class="flex items-start w-1/2 text-gray-700 px-2 mr-auto">
                        </div>
                        <div class="-mr-1">
                        <input type='submit' class="bg-white text-gray-700 font-medium py-1 px-4 border border-gray-400 rounded-lg tracking-wide mr-1 hover:bg-gray-100" value='Add status'>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    
        @foreach($posts as $post)
            <div class="flex mx-auto items-center justify-center shadow-lg mx-8 mb-4 max-w-lg">
                <div class="w-full max-w-xl bg-white rounded-lg px-4 pt-2">
                    <div class="flex items-center space-x-4 mt-4">
                        <img class="w-10 h-10 rounded-full" src="{{ $post->user->avatar  ?? null }}" alt="">
                        <div class="space-y-1 font-medium dark:text-white">
                            <div>{{ $post->user->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Post at {{ Carbon\Carbon::parse($post->created_at)->format('H:i:s') }} </div>
                        </div>
                    </div>
                    <p class="px-1 font-black pt-3 pb-2 text-gray-800  text-lg">{{ $post->body }}</p>
                    
                    <form action="{{ url('posts', [ $post->id ]) }}" method="POST">
    					<input type="hidden" name="_method" value="DELETE">
   						<input type="hidden" name="_token" value="{{ csrf_token() }}">     
   						<input type="submit" class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900" value="Delete"/>
   				    </form>
                    
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <form method="POST" action="{{ route('comments.store') }}" class="w-full max-w-xl bg-white rounded-lg px-2 pt-2">
                            @csrf
                            <h2 class="px-4 pb-2 text-gray-800 text-lg">Add a new comment</h2>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="w-full md:w-full px-3 mb-2 mt-2">
                                <textarea name="body" class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" name="body" placeholder='Type Your Comment' required>{{ old('body') }}</textarea>
                                @if (Session::has('successfulComment'))
                                    <div class="mb-2 text-sm text-green-700 dark:text-green-800" role="alert">
                                        {!! \Session::get('successfulComment') !!}
                                    </div>
                                @endif
                            </div>
                            <div class="w-full md:w-full flex items-start md:w-full px-3">
                                <div class="flex items-start w-1/2 text-gray-700 px-2 mr-auto">
                                </div>
                                <div class="-mr-1">
                                <input type='submit' class="bg-white text-gray-700 font-medium py-1 px-4 border border-gray-400 rounded-lg tracking-wide mr-1 hover:bg-gray-100" value='Add Comment'>
                                </div>
                            </div>
                        </form>
                        <div class="flex flex-col">
                            @foreach($post->comments as $comment)
                                <div class="flex items-center space-x-4 mt-4 mx-6 border-x-4">
                                    <img class="w-10 h-10 rounded-full" src="{{ $comment->user->avatar ?? null }}" alt="">
                                    <form method="POST" action="{{ route('comments.store') }}">
                                        @csrf
                                        <div class="space-y-1 font-medium dark:text-white">
                                            <div>{{ $comment->user->name }}</div>
                                            <div class="text-sm dark:text-gray-400">{{ $comment->body  }}</div>
                                            {{-- <form action="{{ url('comments', [ $post->id ]) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                   <input type="hidden" name="_token" value="{{ csrf_token() }}">     
                                                   <input type="submit" class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900" value="Delete"/>
                                            </form> --}}
                                            <a href="#" onclick="myFunction()" class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 dark:hover:bg-blue-300">Balas</a>
                                            <input type="hidden" name="comment_id" value="{{ $comment->id  }}" />
                                            <input type="hidden" name="post_id" value="{{ $post->id  }}" />
                                            <div style="display:none" id="show-form-reply">
                                                <textarea  name="body" class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-13 py-2 px-3 font-small placeholder-gray-700 focus:outline-none focus:bg-white" name="body" placeholder='Type Your Comment'>{{ old('body') }}</textarea>
                                                <input type='submit' class="bg-white text-gray-700 font-small py-1 px-4 border border-gray-400 rounded-lg tracking-wide mr-1 hover:bg-gray-100" value='Reply'>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @foreach($comment->replies as $reply) 
                                    <div class="flex items-center space-x-4 mt-4 mx-6 ">
                                        <img class="w-10 h-10 rounded-full ml-10" src="{{ $reply->user->avatar ?? null }}" alt="">
                                        <form method="POST" action="">
                                            @csrf
                                            <div class="space-y-1 font-medium dark:text-white">
                                                <div>{{ $reply->user->name  }}</div>
                                                <div class="text-sm dark:text-gray-400">{{ $reply->body  }}</div>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach 
                            @endforeach 
                        </div>
                    </div>
                </div>
            </div>
        @endforeach 
    </div>
@endsection 

@push('js') 
    <script>
        function myFunction() {
            var x = document.getElementById("show-form-reply");
            if (x.style.display === "none") {
                x.style.display = "block";
                } else {
                    x.style.display = "none";
            }
        }
    </script>
@endpush

