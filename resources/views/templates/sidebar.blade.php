<ul class="nav">
  <li class="nav-item nav-profile">
    <a href="#" class="nav-link">
      <div class="profile-image">
        <img class="img-xs rounded-circle" src="{{ asset('pictures/' . auth()->user()->foto) }}" alt="profile image">
        <div class="dot-indicator bg-success"></div>
      </div>
      <div class="text-wrapper">
        @php
        $user_name = auth()->user()->nama;
        if(strlen($user_name) > 12){
          $nama = substr($user_name, 0, 12) . '..';
        }else{
          $nama = $user_name;
        }
        @endphp
        <p class="profile-name">{{ $nama }}</p>
        <p class="designation">{{ auth()->user()->role }}</p>
      </div>
    </a>
  </li>
  <li class="nav-item nav-category">Daftar Menu</li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/dashboard') }}">
      <span class="menu-title">Dashboard</span>
    </a>
  </li>
  @php
  $access = \App\Acces::where('user', auth()->user()->id)
  ->first();
  @endphp
  @if($access->kelola_akun == 1)
  <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#kelola_akun" aria-expanded="false" aria-controls="kelola_akun">
      <span class="menu-title">Kelola Akun</span>
      <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="kelola_akun">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/account') }}">Daftar Akun</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/access') }}">Hak Akses</a>
        </li>
      </ul>
    </div>
  </li>
  @endif
  @if($access->kelola_barang == 1)
  @if(\App\Supply_system::first()->status == true)
  <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#kelola_barang" aria-expanded="false" aria-controls="kelola_barang">
      <span class="menu-title">Kelola Barang</span>
      <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="kelola_barang">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/product') }}">Daftar Barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/supply') }}">Pasok Barang</a>
        </li>
      </ul>
    </div>
  </li>
  @else
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/product') }}">
      <span class="menu-title">Kelola Barang</span>
    </a>
  </li>
  @endif
  @endif
  @if($access->transaksi == 1)
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/transaction') }}">
      <span class="menu-title">Transaksi</span>
    </a>
  </li>
  @endif
  @if($access->kelola_laporan == 1)
  <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#kelola_laporan" aria-expanded="false" aria-controls="kelola_laporan">
      <span class="menu-title">Kelola Laporan</span>
      <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="kelola_laporan">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/report/transaction')  }}">Laporan Transaksi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/report/workers') }}">Laporan Pegawai</a>
        </li>
      </ul>
    </div>
  </li>
  @endif
</ul>