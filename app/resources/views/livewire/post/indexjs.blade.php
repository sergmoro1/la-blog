{{--
  @var object $posts List of posts
  @var integer $page The page to return to 
--}}
  <section class="section main-section">
    <div class="card has-table">
      <div class="card-content">
        <table id="data-table">
          <thead>
              <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Title</th>
                <th>Excerpt</th>
                <th>Tags</th>
                <th>Created</th>
              </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>
  <livewire:alert-modal/>
