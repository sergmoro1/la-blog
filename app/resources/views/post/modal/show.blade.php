<div class="modal-background --jb-modal-close"></div>
<div class="modal-card">
  <header class="modal-card-head">
    <p class="modal-card-title space-x-4">
        <span class="text-xs">#{{ $post->id }}</span>, 
        <span class="text-xs">{{ $post->created_at}}</span>
    </p>
  </header>
  <section class="modal-card-body">
    <div class="container">
      <p class="mb-8 text-xl">{{ $post->title }}</p>
      <div class="basis-1 rounded text-l font-light mb-8">
          {{ $post->excerpt }}
      </div>
      <div class="basis-1 rounded font-thin mb-20">
          {{ $post->content }}
      </div>
      <div class="flex flex-row text-xs">
          @foreach ($post->tags as $tag)
            <div class="bg-gray-500 hover:bg-gray-600 p-3 mr-3 rounded">
                #{{ $tag->name }}
            </div>
          @endforeach
      </div>
    </div>
  </section>
  <footer class="modal-card-foot">
    <button class="button --jb-modal-close" onclick=
      "document.getElementById('modal-show').classList.remove('active');"
    >
      {{ __('Cancel') }}
    </button>
  </footer>
</div>
