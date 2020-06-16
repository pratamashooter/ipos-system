@foreach($supplies as $supply)
<tr>
  <td data-toggle="tooltip" data-placement="top" title="{{ date('d M, Y', strtotime($supply->created_at)). ' pada ' . date('h:m', strtotime($supply->created_at)) }}">{{ date('d M, Y', strtotime($supply->created_at)) }}</td>
  <td>{{ $supply->pemasok }}</td>
  <td>
    <input type="text" name="harga_beli" hidden="" value="{{ $supply->harga_beli }}">
    <span class="ammount-box-2 bg-green"><i class="mdi mdi-coin"></i></span>Rp. {{ number_format($supply->harga_beli,2,',','.') }}</td>
  <td class="percent-status"></td>
  <td>
    <a role="button" href="#" class="ammount-box-2 bg-secondary info-btn" data-container="body" data-toggle="popover" data-placement="left" data-content="">
      <i class="mdi mdi-information-outline"></i>
    </a>
  </td>
</tr>
@endforeach
<tr hidden="">
  <td></td>
  <td></td>
  <td><input type="text" name="harga_beli" value="0"></td>
  <td class="percent-status"></td>
  <td></td>
</tr>