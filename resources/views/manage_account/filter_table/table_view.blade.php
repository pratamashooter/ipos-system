@foreach($users as $user)
<tr>
  <td>
  	<img src="{{ asset('pictures/' . $user->foto) }}">
  	<span class="ml-2">{{ $user->nama }}</span>
  </td>
  <td>{{ $user->email }}</td>
  <td>
    @if($user->role == 'admin')
    <span class="btn admin-span">{{ $user->role }}</span>
    @else
    <span class="btn kasir-span">{{ $user->role }}</span>
    @endif
  </td>
  <td>
  	<button type="button" class="btn btn-icons btn-rounded btn-secondary">
        <i class="mdi mdi-pencil"></i>
    </button>
    <button type="button" class="btn btn-icons btn-rounded btn-secondary ml-1">
        <i class="mdi mdi-close"></i>
    </button>
  </td>
</tr>
@endforeach