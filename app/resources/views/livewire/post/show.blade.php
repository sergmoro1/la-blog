 {{--
  @var object $post - Choiced post
--}}
  <div class="container">
    <div class="flex flex-row mb-8">
        <div class="basis-2/3 p-2 bg-blue-50 rounded text-xl font-light">
            {{ $post->excerpt }}
        </div>
    </div>
    <div class="flex flex-row mb-20">
        <div class="basis-2/3 p-2 rounded font-thin">
            {{ $post->content }}
        </div>
    </div>
  </div>
