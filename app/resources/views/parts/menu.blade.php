  <div class="aside-tools">
    <div>
      Admin <b class="font-black">One</b>
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <x-menu-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">{{ __('Dashboard') }}</span>
      </x-menu-link>
    </ul>
    <p class="menu-label">{{ __('Posts') }}</p>
    <ul class="menu-list">
      <x-menu-link :href="route('post-index')" :active="request()->routeIs('post-index')">
          <span class="icon"><i class="mdi mdi-table"></i></span>
          <span class="menu-item-label">{{ __('Index') }}</span>
      </x-menu-link>
      <x-menu-link :href="route('post-indexjs')" :active="request()->routeIs('post-indexjs')">
          <span class="icon"><i class="mdi mdi-table"></i></span>
          <span class="menu-item-label">{{ __('Indexjs') }}</span>
      </x-menu-link>
      <x-menu-link :href="route('post-create')" :active="request()->routeIs('post-create')">
          <span class="icon"><i class="mdi mdi-pencil-plus-outline"></i></span>
          <span class="menu-item-label">{{ __('Add') }}</span>
      </x-menu-link>
      <li class="--set-active-profile-html">
        <a href="profile.html">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Profile</span>
        </a>
      </li>
      <li>
        <a href="login.html">
          <span class="icon"><i class="mdi mdi-lock"></i></span>
          <span class="menu-item-label">Login</span>
        </a>
      </li>
      <li>
        <a class="dropdown">
          <span class="icon"><i class="mdi mdi-view-list"></i></span>
          <span class="menu-item-label">Submenus</span>
          <span class="icon"><i class="mdi mdi-plus"></i></span>
        </a>
        <ul>
          <li>
            <a href="#void">
              <span>Sub-item One</span>
            </a>
          </li>
          <li>
            <a href="#void">
              <span>Sub-item Two</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    <p class="menu-label">About</p>
    <ul class="menu-list">
      <li>
        <a href="https://justboil.me" onclick="alert('Coming soon'); return false" target="_blank" class="has-icon">
          <span class="icon"><i class="mdi mdi-credit-card-outline"></i></span>
          <span class="menu-item-label">Premium Demo</span>
        </a>
      </li>
      <li>
        <a href="https://justboil.me/tailwind-admin-templates" class="has-icon">
          <span class="icon"><i class="mdi mdi-help-circle"></i></span>
          <span class="menu-item-label">About</span>
        </a>
      </li>
      <li>
        <a href="https://github.com/justboil/admin-one-tailwind" class="has-icon">
          <span class="icon"><i class="mdi mdi-github-circle"></i></span>
          <span class="menu-item-label">GitHub</span>
        </a>
      </li>
    </ul>
  </div>
