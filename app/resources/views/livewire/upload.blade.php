<div class='card'>
  <div class="card-content">
    <div class='field'>
      <label class='label' for='file_input'>{{ __('Images') }}</label>
      <div class='control'>
        <span class='button blue fileinput-button'>
          {{ __('Choose a file') }}
          <input class='input' type='file' name='file_input' id='file_input' multiple>
        </span>
      </div>
    </div>
  </div>
</div>
<div class='card'>
  <div class="card-content">
    <div id='uploads'>
      <ul class='table'>
        @foreach ($model->images as $image)
          <li id={{$image->id}}>
            <span class='block'>
              <img src='{{$image->getThumbnailUrl()}}'>
              @include('livewire.upload.tools')
            </span>
            
            @include('livewire.upload.line', ['id' => $image->id, 'addons' => json_decode($image->addons)])

            <span class='buttons'>
              @include('livewire.upload.buttons')
            </span>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>