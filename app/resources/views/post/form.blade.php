{{--
  @var App\Models\Post $post
--}}
<form method="post" action="<?= ($action == "create") ? "/post-store" : "/post-update/{$post->id}" ?>">
  @csrf
  <div class="grid grid-cols-2 gap-6 lg:grid-cols-2 mb-6">
    <div class="card">
      <div class="card-content">
        <div class="field">
          <label class="label" for="title">Title</label>
          <div class="control">
            <input class="input" type="text" name="title" id="title" 
              placeholder="{{ __('Briefly about the content') }}" 
              value="{{ old('title', $post->title) }}"
            >
          </div>
          <p class="help text-red-500">
             @error('title') <span class="error">{{ $message }}</span> @enderror
          </p>
        </div>

        <div class="field">
          <label class="label" for="excerpt">Excerpt</label>
          <div class="control">
            <textarea class="textarea" name="excerpt" id="excerpt" placeholder="{{ __('Main value of content') }}"
            >{{ old('excerpt', $post->excerpt) }}</textarea>
          </div>
          <p class="help text-red-500">
            @error('excerpt') <span class="error">{{ $message }}</span> @enderror
          </p>
        </div>

      </div>
    </div>
    <div class="card">
      <div class="card-content">
        <div class="field">
          <label class="label" for="status">{{ __('Status') }}</label>
          <div class="control">
            <div class="select">
              <select name="status" id="status">
                <option value="disabled">{{__('Please select') }}</option>
                <option <?= old("status", $post->status) == 'draft' ? 'selected' : '' ?>>draft</option>
                <option <?= old("status", $post->status) == 'published' ? 'selected' : '' ?>>published</option>
                <option <?= old("status", $post->status) == 'archived' ? 'selected' : '' ?>>archived</option>
              </select>
            </div>
          </div>
          <p class="help text-red-500">
             @error('status') <span class="error">{{ $message }}</span> @enderror
          </p>         
        </div>
        <div class="field">
          <label class="label" for="select-tags">{{ __('Tags') }}</label>
          <div class="control">
            <div class="select">
              <select id="select-tags" name="tags[]" multiple>
                @foreach ($post->tags as $tag)
                  <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <p class="help text-red-500">
             @error('tags') <span class="error">{{ $message }}</span> @enderror
          </p>         
        </div>
      </div>
    </div>
  </div>
  
  <div class="grid grid-cols-1 mb-6">
    <x-imageable-upload :model="$post"/>
  </div>
  
  <div class="grid grid-cols-1 mb-6">
    <div class="card">
      <div class="card-content">
        <div class="field">
          <label class="label" for="content">Content</label>
          <div class="control">
            <textarea class="textarea" name="content" id="content" placeholder="{{ __('Full content') }}"
            >{{ old('content', $post->content) }}</textarea>
          </div>
          <p class="help text-red-500">
            @error('content') <span class="error">{{ $message }}</span> @enderror
          </p>
        </div>
        <hr />
        <div class="field grouped">
          <div class="control">
            <button type="submit" class="button green">
              Submit
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
