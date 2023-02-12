{{--
  @var integer $post_id Post ID
  @var string $action Action that must be done 
--}}
<x-app-layout>
    <x-slot name="css">
      @if ($action == 'Form')
        <link href="{{ url('css/select.css') }}" rel="stylesheet">
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
          @if ($action == 'Index')
            {{ __('A list of posts') }}
          @elseif ($action == 'Add')
            {{ __('Add') }} {{ __('an awesome post') }}
          @else
            {{ __('Read') }} {{ __('an awesome post') }}
          @endif
        </h1>
        @if ($action == 'Index')
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
      @if ($action == 'Form')
        <script src="/js/select.js"></script>
      @endif
    </x-slot>
    @if ($action == 'Index')
      <livewire:post.index/>
    @endif
    @if ($action == "Show")
      <livewire:post.show :post_id="$post_id"/>
    @endif
    @if ($action == "Form")
      <livewire:post.form/>
    @endif
</x-app-layout>

