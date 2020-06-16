@foreach($access as $user)
<tr>
  <td>
    <span class="d-flex justify-content-start align-items-center">
      <img src="{{ asset('pictures/' . $user->foto) }}">
      <span class="ml-2">
        <span class="d-block mb-1">{{ $user->nama }}</span>
        <span class="txt-user-desc">{{ $user->role }} <i class="mdi mdi-checkbox-blank-circle dot"></i> {{ $user->email }}</span>
      </span>
    </span>
  </td>
  <td class="text-center b-left" data-access="kelola_akun" data-user="{{ $user->user }}" data-role="{{ $user->role }}">
    @if($user->kelola_akun == 1)
    <div class="btn-checkbox btn-access">
        <i class="mdi mdi-checkbox-marked"></i>
    </div>
    @else
    <div class="btn-checkbox btn-non-access">
        <i class="mdi mdi-checkbox-blank-outline"></i>
    </div>
    @endif
  </td>
  <td class="text-center b-left" data-access="kelola_barang" data-user="{{ $user->user }}" data-role="{{ $user->role }}">
    @if($user->kelola_barang == 1)
    <div class="btn-checkbox btn-access">
        <i class="mdi mdi-checkbox-marked"></i>
    </div>
    @else
    <div class="btn-checkbox btn-non-access">
        <i class="mdi mdi-checkbox-blank-outline"></i>
    </div>
    @endif
  </td>
  <td class="text-center b-left" data-access="transaksi" data-user="{{ $user->user }}" data-role="{{ $user->role }}">
    @if($user->transaksi == 1)
    <div class="btn-checkbox btn-access">
        <i class="mdi mdi-checkbox-marked"></i>
    </div>
    @else
    <div class="btn-checkbox btn-non-access">
        <i class="mdi mdi-checkbox-blank-outline"></i>
    </div>
    @endif
  </td>
  <td class="text-center b-left" data-access="kelola_laporan" data-user="{{ $user->user }}" data-role="{{ $user->role }}">
    @if($user->kelola_laporan == 1)
    <div class="btn-checkbox btn-access">
        <i class="mdi mdi-checkbox-marked"></i>
    </div>
    @else
    <div class="btn-checkbox btn-non-access">
        <i class="mdi mdi-checkbox-blank-outline"></i>
    </div>
    @endif
  </td>
</tr>
@endforeach