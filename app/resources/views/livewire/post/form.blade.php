    <div class="card mb-6">
      <div class="card-content">
        <form method="post" wire:submit.prevent="submit">
          @csrf
          <div class="field">
            <label class="label">Status</label>
            <div class="control">
              <div class="select">
                <select wire:model="status">
                  <option>draft</option>
                  <option>published</option>
                  <option>archived</option>
                </select>
              </div>
            </div>
            <p class="help text-red-500">
               @error('status') <span class="error">{{ $message }}</span> @enderror
            </p>         
          </div>
          <div class="field">
            <label class="label">Title</label>

            <div class="control">
              <input class="input" type="text" wire:model="title" placeholder="Briefly about the content">
            </div>
            <p class="help text-red-500">
               @error('title') <span class="error">{{ $message }}</span> @enderror
            </p>
          </div>

          <div class="field">
            <label class="label">Excerpt</label>
            <div class="control">
              <textarea class="textarea" wire:model="excerpt" placeholder="Main value of content"></textarea>
            </div>
            <p class="help text-red-500">
              @error('excerpt') <span class="error">{{ $message }}</span> @enderror
            </p>
          </div>

          <div class="field">
            <label class="label">Content</label>
            <div class="control">
              <textarea class="textarea" wire:model="content"></textarea>
            </div>
            <p class="help text-red-500">
              @error('content') <span class="error">{{ $message }}</span> @enderror
            </p>
          </div>
          <hr>

          <div class="field grouped">
            <div class="control">
              <button type="submit" class="button green">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
