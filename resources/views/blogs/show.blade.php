<x-layout>

    <div class="flex flex-row p-4 space-x-4 items-start w-screen">
        <div class="flex-grow rounded bg-white border border-gray-300 shadow-lg">
            <div class="flex flex-col p-6">

                <span class="text-xl text-center">Блог</span>

                <div class="mt-4 mx-auto">
                    <div class="flex justify-around items-center">
                        {{-- image --}}
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('storage/' . $blog->photo_path) }}" alt=""
                                class="w-[550px] h-[350px] object-contain rounded-xl">
                        </div>

                        {{-- main title --}}
                        <div class="my-2">
                            <h1 class="font-bold text-xl">{{ $blog->title }}</h1>
                            <p class="text-sm font-semibold text-slate-700">
                                <span class="text-accent">Од: {{ $blog->user->name }} {{ $blog->user->surname }}
                                </span>
                                | {{ $blog->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- titel and description --}}
                    <div class="my-2">
                        <h1 class="font-bold text-2xl">{{ $blog->title }}</h1>
                        <p class="max-w-[800px]"> {{ $blog->description }}</p>
                    </div>

                    {{-- sections --}}
                    <div class="my-6 p-4">
                        @foreach ($sections as $index => $section)
                            <div class="mb-4">
                                <h3 class="text-xl font-semibold">{{ $section['section_title'] }}</h3>
                                <p class="text-gray-700 max-w-[800px]">{{ $section['section_body'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- like and comment button --}}
                <div class="flex space-x-10 justify-center">
                    <div class="flex">
                        <form id="like-form" action="{{ route('blogs.like', $blog) }}" method="POST">
                            @csrf
                            <button type="button" id="like-button">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="{{ $blog->likes()->where('user_id', Auth::id())->exists() ? 'blue' : 'white' }}"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                </svg>
                            </button>
                        </form>

                        <span id="like-count">{{ $blog->likes()->count() }}</span>
                    </div>

                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>

                        {{ $blog->comments()->whereNull('deleted_at')->whereNull('parent_id')->count() }}
                    </div>
                </div>

                <div class="overflow-y-auto space-y-2">
                    <h1 class="text-3xl font-semibold my-8">Коментари</h1>

                    {{-- user add comment --}}
                    <div class="mt-6">
                        <form action="{{ route('comments.store', $blog->id) }}" method="POST">
                            @csrf
                            <textarea name="content" class="w-full p-2 border rounded" rows="4" placeholder="Write your comment..."></textarea>
                            <button type="submit" class="mt-2 bg-blue-500 text-white p-2 rounded">Коментирај</button>
                        </form>
                    </div>


                    {{-- all comments with its replies --}}
                    @foreach ($blog->comments->whereNull('deleted_at')->whereNull('parent_id') as $comment)
                        <div class="rounded border border-gray-300 shadow-lg bg-white">
                            <div class="flex flex-col p-4">
                                <div class="mt-2 flex items-center space-x-4">

                                    <div>
                                        <img src="{{ $comment->user->photo_path }}" alt="will upload later"
                                            class="relative inline-block h-9 w-9 rounded-full object-cover object-center" />
                                    </div>

                                    <div>
                                        <h1 class="font-semibold italic text-xl">
                                            {{ $comment->user->name }} {{ $comment->user->surname }}
                                        </h1>
                                        <p> {{ $comment->created_at->diffForHumans() }}</p>
                                    </div>

                                </div>

                                <p>{{ $comment->content }}</p>

                                {{-- like and reply buttons --}}
                                <div class="flex space-x-4 mt-2 text-sm">
                                    <form id="like-comment-form-{{ $comment->id }}"
                                        action="{{ route('comments.like', $comment->id) }}" class="flex items-center"
                                        method="POST">
                                        @csrf
                                        <button type="button" id="like-comment-button-{{ $comment->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="{{ $comment->isLikedBy(auth()->user()) ? 'blue' : 'white' }}"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-6 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                            </svg>
                                        </button>

                                        <span id="like-count-{{ $comment->id }}">{{ $comment->likes }}</span>
                                    </form>

                                    <!-- comment reply form toggle button -->
                                    <button onclick="toggleReplyForm({{ $comment->id }})"> <svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                        </svg></button>
                                </div>

                                <!-- Reply Form (Hidden Initially) -->
                                <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
                                    <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                        <textarea name="content" class="w-full p-2 border rounded" rows="2" placeholder="Write your reply..."></textarea>
                                        <button type="submit"
                                            class="mt-2 bg-blue-500 text-white p-2 rounded">Reply</button>
                                    </form>
                                </div>

                                {{-- reply withing its parent comment --}}
                                <div class="ml-6 mt-4 border-l border-gray-300 pl-4">
                                    @foreach ($comment->replies as $reply)
                                        @if ($reply->parent_id)
                                            <div class="mt-2">
                                                <div class="mt-2 flex items-center space-x-4">
                                                    <img src="{{ $reply->user->photo_path }}" alt="will upload later"
                                                        class="relative inline-block h-9 w-9 rounded-full object-cover object-center" />

                                                    <div>
                                                        <h1 class="font-semibold italic text-lg">
                                                            {{ $reply->user->name }} {{ $reply->user->surname }}
                                                        </h1>
                                                        <p class="text-xs"> {{ $reply->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>

                                                </div>
                                                <p>{{ $reply->content }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // toggle reply form
        function toggleReplyForm(commentId) {
            let replyForm = document.getElementById('reply-form-' + commentId);
            replyForm.classList.toggle('hidden');
        }

        // Ajax Call for Blog Like

        $(document).ready(function() {
            $('#like-button').on('click', function(e) {
                e.preventDefault();

                var form = $('#like-form'); 
                var url = form.attr('action'); 
                var token = $('input[name="_token"]').val(); 
                var likeCount = $('#like-count'); 
                var likeButton = $(this).find('svg'); 

                // Send AJAX request
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        // Update the like count
                        likeCount.text(response.likesCount);

                        s
                        if (response.liked) {
                            likeButton.attr('fill', 'blue'); // change to blue if liked
                        } else {
                            likeButton.attr('fill', 'white'); // change to white if unliked
                        }
                    },
                    error: function(xhr) {
                        console.log('An error occurred:', xhr.responseText);
                    }
                });
            });
        });

        //  Ajax Call for Comment Like
        $(document).ready(function() {
            $('[id^=like-comment-button]').on('click', function(e) {
                e.preventDefault();

                var commentId = $(this).attr('id').split('-').pop(); 
                var form = $('#like-comment-form-' + commentId);
                var url = form.attr('action');
                var token = form.find('input[name="_token"]').val();
                var likeButton = $(this).find('svg'); 
                var likeCount = $('#like-count-' + commentId); 

                // AJAX request to handle like/unlike
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        // Change the SVG fill color based on like status
                        if (response.liked) {
                            likeButton.attr('fill', 'blue'); // Liked
                        } else {
                            likeButton.attr('fill', 'white'); // Unliked
                        }
                        // Update the like count
                        likeCount.text(response.likeCount);
                    },
                    error: function(xhr) {
                        console.log('An error occurred:', xhr.responseText);
                    }
                });
            });
        });
    </script>
</x-layout>
