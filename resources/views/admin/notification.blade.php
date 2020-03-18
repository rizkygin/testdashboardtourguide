@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i> Notification
              <button type="button" class="btn btn-primary btnAdd ml-10 pull-right" data-toggle="collapse" data-target="#collapseExample"><i class="nav-icon icon-plus"></i> Add Notification</button>
            </div>
            @if(Session::has('Success'))
            <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                <strong>Success!</strong> Data has been saved.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="collapse p-3" id="collapseExample">
                <div class="card card-body">
                    <form method="POST" action="{{ route('admin.notification.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="category_id" name="category_id" value="2">
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Notification Title')}}</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label">{{ __('Description ') }}</label>

                            <div class="col-md-9">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description"></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
                    <thead>
                        <tr>
                            <th style="text-align: center;" class="col-sm-1">No</th>
                            <th style="text-align: center;" class="col-md-2">Notification Title</th>
                            <th style="text-align: center;" class="col-md-3">Description</th>
                            <th style="text-align: center;" class="col-md-1">Status</th>
                            <th style="text-align: center;" class="col-md-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;
                      @endphp
                      @foreach ($notif as $data)
                        <tr id="{{ $data->id }}">
                            <td style="text-align: center;">{{$no}}</td>
                            <td style="text-align: center;">{{$data->name}}</td>
                            <td style="text-align: center;">{{$data->description}}</td>
                            <td style="text-align: center;color:#fff"><span class="badge bg-success">Posted</span></td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-info btnEdit" id="{{$data->id}}" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i></button>
                                <button type="button" class="btn btn-danger btnDelete" id="{{$data->id}}"><i class="nav-icon icon-trash"></i></button>
                                <!--<a type="button" class="btn btn-success" href="{{route('admin.notification.show', $data->id)}}" id="{{ $data->id }}" target="_blank"><i class="nav-icon icon-info"></i></a> -->
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
   
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Notification</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="frmData" method="POST" action="" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="modal-body">
          <input type="hidden" id="category_id" name="category_id" value="2">
          <div class="form-group">
            <label>Notification Title</label>
            <input id="nameEdit" type="text" class="form-control" name="name" placeholder="Hotel Name" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <input id="descriptionEdit" type="text" class="form-control" name="description" placeholder="Description" required>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
    
<script type="text/javascript">

  $('#user-table').DataTable()

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');
    var action = "{{route('admin.notification.index')}}/"+id;
    $('#frmData').attr('action', action);
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var description=row.find("td:eq(2)").text();

    $('#nameEdit').val(name);
    $('#descriptionEdit').val(description);

  });

  $(document).on('click', '.btnLocation', function(e) {
    e.preventDefault;
    var row=$(this).closest("tr"); 
         
    var lat=row.find("td:eq(3)").text();
    var lng=row.find("td:eq(4)").text();

    window.open("https://www.google.com/maps/@"+lat+","+lng+",15z", '_blank');

  });
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $(document).on('click', '.btnDelete', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.notification.index') }}/"+sid;
    console.log(url)
    if(confirm("Are you sure you want to delete this?")){ 
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