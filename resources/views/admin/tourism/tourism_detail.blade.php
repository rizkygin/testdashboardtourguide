@extends('admin.layouts.app')

@push('css')
<style>
.hide_column {
    display : none;
}
</style>
@endpush

@section('content')
<hr>
<div class="container bootstrap snippet">
  <div class="row align-items-end">
    <div class="col-sm-6" style="padding-bottom:10px;"><h2>{{$data->name}}</h2></div>
    <div class="col-sm-6" style="">
      <a class="btn btn-primary btnAdd ml-2 pull-right" style="color:#fff;" data-toggle="modal" data-target="#addPhoto">Add Photo</a>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addPhoto" tabindex="-1" role="dialog" aria-labelledby="addPhotoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <form method="POST" enctype="multipart/form-data" action="{{route('admin.gallery.store')}}">
          @csrf
          <input type="hidden" name="tourism_id" value="{{$data->id}}">
          <div class="modal-header">
            <h5 class="modal-title" id="addPromoTitle">Add Photo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <label class="col-form-label">Photo :</label>
            <div class="custom-file">
              <input type="file" name="photo" class="custom-file-input" id="customFile">
              <label class="custom-file-label" for="customFile">Choose photo</label>
            </div>
            <div class="form-group">
              <label for="descpromo" class="col-form-label">Description:</label>
              <textarea name="description" class="form-control" id="desc-promo"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div> <!--END MODAL-->

  <div class="row my-3">
    <div class="col-sm-3"><!--left col-->
      <div class="text-center">
        <img src="{{asset('storage/'.$data->photo)}}" onerror="this.onerror=null; this.src='{{$data->photo}}'"  class="avatar img-circle img-thumbnail w-100" alt="avatar" >
        <!--<input type="file" class="text-center center-block file-upload">-->
      </div>
        
    </div><!--/col-3-->

    <div class="col-sm-9">
      <div class="tab-pane" id="settings">
        <!-- body card profile detail -->                 
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
                <h5>Tourism Detail</h5>
              </div>
              <div class="card-body" style="font-size:16px;">
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Tourism Name </div>
                  <div class="col-sm"> {{$data->name}} </div>
                </div>
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Address </div>
                  <div class="col-sm"> {{$data->address}} </div>
                </div>
                @if ($data->description)
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">
                    Description </div>
                  <div class="col-sm"> {{$data->description}} </div>
                </div>
                @endif
                @if ($data->latitude)
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Latitude </div>
                  <div class="col-sm"> {{$data->latitude}} </div>
                </div>
                @endif
                @if ($data->longitude)
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Longitude </div>
                  <div class="col-sm"> {{$data->longitude}} </div>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        <!-- sampe sini -->

      </div>
    </div><!-- sampe sini -->
  </div><!--/tab-pane-->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
          <h5>List Photo</h5>
        </div>
        <div class="card-body" style="">
          <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Photo</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              @php
                $no = 1;
              @endphp
              @foreach ($data->gallery as $d)
                <tr id="{{$d->id}}">
                    <td>{{$no}}</td>
                    <td><img src="{{asset('storage/'.$d->photo)}}" style="width:100px;" onerror="this.onerror=null; this.src='{{$d->photo}}'" class="avatar img-circle img-thumbnail" alt="avatar" ></td>
                    <td style="text-align: center;">{{$d->description}}</td>
                    <td style="text-align: center;">
                        <a type="button" id="{{$d->id}}" class="btn btn-success btnPromo" style="color:#fff" data-toggle="modal" data-target="#addPromo"><i class="nav-icon icon-plus"></i></a>
                        <a type="button" id="{{$d->id}}" class="btn btn-danger btnDelete" style="color:#fff" ><i class="nav-icon icon-trash"></i></a>
                    </td>
                </tr>
              @php
                $no++
              @endphp
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


@endsection

@push('scripts')
    
<script type="text/javascript">

  $('#user-table').DataTable({
    columnDefs: [
      {
        "targets": [ 2, 4 ],
        "className": "hide_column",
        "searchable": false
      },
    ]
  });

  $('#promo-table').DataTable();

  $(document).on('click', '.btnShow', function(e) {
    e.preventDefault;
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var desc=row.find("td:eq(2)").text();
    var price=row.find("td:eq(3)").text();
    var photo=row.find("td:eq(4)").text();

    $('#itemName').text(name);
    $('#itemDesc').text(desc);
    $('#itemPrice').text('Rp. '+ price);
    $('#itemPhoto').attr('src', photo);

  });

  $(document).on('click', '.btnPromo', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');

    $('#item_id').val(id);

  });

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');
    var action = "{{route('admin.guide.index')}}/"+id;
    $('#frmData').attr('action', action);
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var email=row.find("td:eq(2)").text();

    $('#nameEdit').val(name);
    $('#emailEdit').val(email);

  });
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $(document).on('click', '.btnDelete', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.item.index') }}/"+sid;
    console.log(url)
    if(confirm("Are you sure you want to delete this?")){ 
        console.log('teet')
        $.ajax({
            type: "delete",
            url: url,
            dataType: "json",
            success: (response) => {
              $(this).closest('tr').remove();
            }
        });
    } 
  });

</script>

@endpush