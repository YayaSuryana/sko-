<div class="main-sidebar">
  <aside id="sidebar-wrapper">

    <div class="sidebar-brand">
      @if (config('stisla.logo_aplikasi') != '')
        <a href="{{ url('') }}">
          <img style="max-width: 60%;" src="{{ asset(config('stisla.logo_aplikasi')) }}"></a>
      @else
        <a href="{{ url('') }}">{{ $_app_name }}</a>
      @endif
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('') }}">{{ $_app_name_mobile }}</a>
    </div>

    <ul class="sidebar-menu">
       {{-- Statis Menu --}}
       {{-- dashboard --}}
       <li class="nav-item {{Request::is('dashboard')?'active':''}}">
        <a href="{{route('dashboard.index')}}" class="nav-link">
          <i class="fas fa-fire"></i>
          <span>Beranda</span>
        </a>
       </li>
       <li class="nav-item {{Request::is('profileatlets/create')?'active':''}}">
        <a href="{{route('profileatlets.create')}}" class="nav-link">
          <i class="fas fa-file"></i>
          <span>Tambah Atlet</span>
        </a>
       </li>
       {{-- PPLP --}}
       <li class="menu-header">PPLP</li>
      <li class="nav-item dropdown">
        <a href="" class="nav-link has-dropdown">
          <i class="fas fa-file"></i>
          <span>Data Atlet</span>
        </a>
        <ul class="dropdown-menu">
          <li class="">
            <a class="nav-link" href="{{route('statistik.pplp')}}">
              <i class="fa-solid fa-chart-pie"></i>
              <span>Statistik</span>
            </a>
            <a class="nav-link" href="{{route('pplp.index')}}">
              <i class="fa-solid fa-address-card"></i>
              <span>Profile Atlet</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fas fa-th"></i>
          <span>Data Pelatih</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('prestasis.index')}}" class="nav-link">
          <i class="fas fa-edit"></i>
          <span>Prestasi</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-vial"></i>
          <span>Hasil Test</span>
        </a>
        <ul class="dropdown-menu">
          <li class="">
            <a class="nav-link" href="">
              <i class="fa-regular fa-address-book"></i>
              <span>Periodik</span>
            </a>
            <a class="nav-link" href="">
              <i class="fa-regular fa-calendar-days"></i>
              <span>Event</span>
            </a>
          </li>
        </ul>
      </li>
      {{-- end PPLP --}}

      {{-- SKO --}}
      <li class="menu-header">SKO</li>
       <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-file"></i>
          <span>Data Atlet</span>
        </a>
        <ul class="dropdown-menu">
          <li class="">
            <a class="nav-link" href="{{route('statistik.sko')}}">
              <i class="fa-solid fa-chart-pie"></i>
              <span>Statistik</span>
            </a>
            <a class="nav-link" href="{{route('sko.index')}}">
              <i class="fa-solid fa-address-card"></i>
              <span>Profile Atlet</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fas fa-th"></i>
          <span>Data Pelatih</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fas fa-edit"></i>
          <span>Prestasi</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-vial"></i>
          <span>Hasil Test</span>
        </a>
        <ul class="dropdown-menu">
          <li class="">
            <a class="nav-link" href="">
              <i class="fa-regular fa-address-book"></i>
              <span>Periodik</span>
            </a>
            <a class="nav-link" href="">
              <i class="fa-regular fa-calendar-days"></i>
              <span>Event</span>
            </a>
          </li>
        </ul>
      </li>
      {{-- end SKO --}}

      {{-- SLOMPN --}}
      <li class="menu-header">SLOMPN</li>
       <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-file"></i>
          <span>Data Atlet</span>
        </a>
        <ul class="dropdown-menu">
          <li class="">
            <a class="nav-link" href="">
              <i class="fa-solid fa-chart-pie"></i>
              <span>Statistik</span>
            </a>
            <a class="nav-link" href="">
              <i class="fa-solid fa-address-card"></i>
              <span>Profile Atlet</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fas fa-th"></i>
          <span>Data Pelatih</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fas fa-edit"></i>
          <span>Prestasi</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-vial"></i>
          <span>Hasil Test</span>
        </a>
        <ul class="dropdown-menu">
          <li class="">
            <a class="nav-link" href="">
              <i class="fa-regular fa-address-book"></i>
              <span>Periodik</span>
            </a>
            <a class="nav-link" href="">
              <i class="fa-regular fa-calendar-days"></i>
              <span>Event</span>
            </a>
          </li>
        </ul>
      </li>
      {{-- end SLOMPN --}}

      <li class="menu-header">Master</li>
      <li class="nav-item">
        <a href="{{route('kodes.index')}}" class="nav-link">
          <i class="fas fa-tag"></i>
          <span>Kode</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('cabors.index')}}" class="nav-link">
          <i class="fas fa-th"></i>
          <span>Cabor</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a href="" class="nav-link has-dropdown">
          <i class="fa-solid fa-award"></i>
          <span>Master Event</span>
        </a>
        <ul class="dropdown-menu">
          <li class="">
            <a class="nav-link" href="{{route('masterevents.index')}}">
              <i class="fa-solid fa-award"></i>
              <span>Master</span>
            </a>
            <a class="nav-link" href="{{route('events.index')}}">
              <i class="fa-solid fa-trophy"></i>
              <span>Event</span>
            </a>
          </li>
        </ul>
      </li>
      @foreach ($_sidebar_menus as $_group)
        <li class="menu-header">{{ __($_group->group_name) }}</li>

        @php
          $_user = auth()->user();
        @endphp
        @foreach ($_group->menus as $_menu)
          {{-- if single menu --}}
          @if ($_menu->childs->count() === 0)
            @php
              $_menu_condition = $_menu->permission === null || $_user->can($_menu->permission);
            @endphp
            @if ($_menu_condition)
              <li @if (Request::is($_menu->is_active_if_url_includes)) class="active" @endif>
                <a class="nav-link" href="{{ $_menu->fix_url }}" @if ($_menu->is_blank) target="_blank" @endif>
                  <i class="{{ $_menu->icon }}"></i>
                  <span>{{ __($_menu->menu_name) }}</span>
                </a>
              </li>
            @endif

            {{-- else with child dropdown menu --}}
          @else
            @php
              $_is_active = $_menu->childs
                  ->pluck('is_active_if_url_includes')
                  ->filter(function ($item) {
                      return Request::is($item);
                  })
                  ->count();
              $_menu_condition = $_menu->childs
                  ->pluck('permission')
                  ->filter(function ($item) use ($_user) {
                      return $_user->can($item);
                  })
                  ->count();
            @endphp
            @if ($_menu_condition)
              <li class="nav-item dropdown @if ($_is_active) active @endif">
                <a href="#" class="nav-link has-dropdown">
                  <i class="{{ $_menu->icon }}"></i>
                  <span>{{ __($_menu->menu_name) }}</span>
                </a>
                <ul class="dropdown-menu">
                  @foreach ($_menu->childs as $_child_menu)
                    @php
                      $_sub_menu_condition = $_child_menu->permission === null || $_user->can($_child_menu->permission);
                    @endphp
                    @if ($_sub_menu_condition)
                      <li @if (Request::is($_child_menu->is_active_if_url_includes)) class="active" @endif>
                        <a class="nav-link" href="{{ $_child_menu->fix_url }}" @if ($_child_menu->is_blank) target="_blank" @endif>
                          {{ __($_child_menu->menu_name) }}
                        </a>
                      </li>
                    @endif
                  @endforeach
                </ul>
              </li>
            @endif
          @endif
        @endforeach
      @endforeach
    </ul>
  </aside>
</div>
