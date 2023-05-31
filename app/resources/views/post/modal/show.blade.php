<div class="modal-background --jb-modal-close"></div>
<div class="modal-card" style="width: 70%!important;">
  <header class="modal-card-head">
    <p class="modal-card-title space-x-4">
        <span class="text-xs">ID: {{ $post->id }}</span>, 
        <span class="text-xs">{{ __('Created at') }}: {{ $post->created_at}}</span>,
        <span class="text-xs">{{ __('Author') }}: {{ $post->user->name }}</span>
    </p>
  </header>
  <section class="modal-card-body">
    <div class="container">
      <div class="is-hero-bar">
        <h1 class="title">{{ $post->title }}</h1>
      </div>
      <div class="basis-1 rounded text-xl font-light mb-8">
          {{ $post->excerpt }}
      </div>
      <div class="basis-1 rounded text-l font-light mb-20">
          {{ $post->content }}
      </div>
      <div class="text-xs font-medium text-gray-600">
          @foreach ($post->tags as $tag)
            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 ring-1 ring-inset ring-gray-500/10">
              #{{ $tag->name }}
            </span>
          @endforeach
      </div>
    </div>
  </section>
  <footer class="modal-card-foot">
    <button class="button blue --jb-modal-close" onclick=
      "document.getElementById('modal-show').classList.remove('active');"
    >
      {{ __('Cancel') }}
    </button>
  </footer>
</div>
