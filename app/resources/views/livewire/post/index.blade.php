{{--
  @var object $posts List of posts
  @var integer $page The page to return to 
--}}
  <section class="section main-section">
    <div class="card has-table">
      <div class="card-content">
        <table>
          <thead>
              <tr>
                <th class="checkbox-cell">
                  <label class="checkbox">
                    <input type="checkbox">
                    <span class="check"></span>
                  </label>
                </th>
                <th>Status</th>
                <th>Title</th>
                <th>Excerpt</th>
                <th>Content</th>
                <th>Created</th>
                <th></th>
              </tr>
          </thead>

          <tbody id="new-page" data-page="{{ $page }}">
            @foreach ($posts as $post)
              <tr>
                <td class="checkbox-cell">
                  <label class="checkbox">
                    <input type="checkbox">
                    <span class="check"></span>
                  </label>
                </td>
                <td data-label="status">{{ $post->status }}</td>
                <td data-label="title">{{ $post->title }}</td>
                <td data-label="excerpt">{{ $post->excerpt }}</td>
                <td data-label="content">{{ $post->content }}</td>
                <td data-label="created">
                  <small class="text-gray-500">{{ $post->created_at}}</small>
                </td>
                <td class="actions-cell">
                  <div class="buttons right nowrap">
                    <a href="{{ route('post-show', ['id' => $post->id]) }}">
                      <button class="button small green" type="button">
                        <span class="icon"><i class="mdi mdi-eye"></i></span>
                      </button>
                    </a>
                    <button class="button small red --jb-modal" 
                        data-target="modal-delete" type="button" 
                        onclick="this.setAttribute('data-id', {{ $post->id }});">
                        <span class="icon">
                          <i class="mdi mdi-trash-can"></i>
                        </span>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{ $posts->links('vendor.pagination.default') }}
      </div>
    </div>
  </section>
  <livewire:alert-modal/>
