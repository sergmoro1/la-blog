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
          {!! $post->markdownToHtml() !!}
      </div>
      <div class="text-xs font-medium text-gray-600 grid grid-cols-2">
        <div class="col-span-1">
          @foreach ($post->tags as $tag)
            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 ring-1 ring-inset ring-gray-500/10">
              #{{ $tag->name }}
            </span>
          @endforeach
        </div>
        <div class="col-span-1">
          <span class="inline-flex items-center px-2 py-1">
            <svg role="presentation" viewBox="0 0 24 24" style="height: 1rem; width: 1rem;">
              <path d="M5,9V21H1V9H5M9,21A2,2 0 0,1 7,19V9C7,8.45 7.22,7.95 7.59,7.59L14.17,1L15.23,2.06C15.5,2.33 15.67,2.7 15.67,3.11L15.64,3.43L14.69,8H21C22.11,8 23,8.9 23,10V12C23,12.26 22.95,12.5 22.86,12.73L19.84,19.78C19.54,20.5 18.83,21 18,21H9M9,19H18.03L21,12V10H12.21L13.34,4.68L9,9.03V19Z" style="fill: currentcolor;"></path>
            </svg>
          </span>
          <span class="inline-flex items-center px-2 pb-4">
              0
          </span>
        </div>
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
