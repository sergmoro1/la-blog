{{--
  @var App\Models\Post $post
  @var string $action Action that must be done 
--}}
<x-app-layout>
    <x-slot name="css">
      @if ($action == 'index')
        <link href="/vendor/DataTables/datatables.min.css" rel="stylesheet">
      @endif
      @if (in_array($action, ['create', 'edit']))
        <link href="/css/fileinput.css" rel="stylesheet">
        <link href="/css/uploads.css" rel="stylesheet">
        <link href="/vendor/select2/dist/css/select2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
      @endif
    </x-slot>
    <x-slot name="title">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <ul>
          <li>{{ __('Post') }}</li>
          <li>{{ __($action) }}</li>
        </ul>
      </div>
    </x-slot>
    <x-slot name="hero">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <h1 class="title">
          @if ($action == 'index')
            {{ __('A list of posts') }}
          @elseif ($action == 'create')
            {{ __('Add') }} {{ __('an awesome post') }}
          @else
            {{ $post->title }}
          @endif
        </h1>
        @if ($action == 'index')
          <a href="/post-create" class="button blue">
            <span class="icon"><i class="mdi mdi-plus"></i></span>
            <span>Add post</span>
          </a>
        @endif
      </div>         
        @if (session()->has('success'))
          <div class="bg-green-100 rounded-lg py-5 px-6 mb-4 text-base text-green-700 mb-3 md:space-y-10 mt-6" role="alert">
            {{ session('success') }}
          </div>
        @endif
        @if (session()->has('error'))
          <div class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3" role="alert">
            {{ session('error') }}
          </div>
        @endif
    </x-slot>
    <x-slot name="scripts">
      @if ($action == 'index')
        <script src="/vendor/jquery/jquery-3.7.0.min.js"></script>
        <script src="/vendor/DataTables/datatables.min.js"></script>
        <script src="/js/post/handler.datatables.js"></script>
      @endif
      @if (in_array($action, ['create', 'edit']))
        <script src="/vendor/jquery/jquery-3.7.0.min.js"></script>
        <script src="/vendor/select2/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="/vendor/jquery-simple-upload/simpleUpload.min.js"></script>
        <script>var uploadOptions = <?= $post->uploadOptions() ?>;</script>
        <script src="/js/simpleUpload/handler.upload.js"></script>
        <script src="/js/post/form.js"></script>
      @endif
    </x-slot>
    @if ($action == 'index')
      @include('post.index')
    @endif
    @if (in_array($action, ["create", "edit"]))
      @include('post.form')
    @endif
</x-app-layout>

