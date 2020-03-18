@extends('admin.layouts.app')


<style>
  .hide_column {
      display : none;
  }
</style>

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i> Reward List
              <!--<button type="button" class="btn btn-primary btnAdd ml-10 pull-right" data-toggle="collapse" data-target="#collapseExample"><i class="nav-icon icon-plus"></i> Add Reward</button>-->
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
                    <form method="POST" action="{{ route('admin.guide.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Name') }}</label>

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
                            <label for="email" class="col-md-3 col-form-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label">{{ __('Confirm Password') }}</label>

                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
                            <th>No</th>
                            <th>Reward Name</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;
                      @endphp
                      @foreach ($data as $item)
                      <tr id="{{$item->id}}">
                            <td>{{$no}}</td>
                            <td>{{$item->reward->name}}</td>
                            <td>{{$item->user->name}}</td>
                            <td>{{$item->created_at}}</td>
                            <td><img src="{{asset('storage/'.$item->photo)}}" style="width:100px;" onerror="this.onerror=null; this.src='{{$item->photo}}'"  class="avatar img-circle img-thumbnail" alt="avatar" ></td>
                            <td style="text-align:center;">
                                <button type="button" class="btn btn-success btnDetail" data-toggle="modal" data-target="#reedemDetail" id="{{$item->id}}"><i class="nav-icon icon-info"></i></button>
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
   
<!--Modal Detail -->
<div class="modal fade" id="reedemDetail" tabindex="-1" role="dialog" aria-labelledby="reedemDetailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tourismDetailTitle">Detail Reedem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-sm-12" style="margin-bottom:15px;">
          <div class="row justify-content-center">
            <div class="view d-flex"  id="detailPhoto" style="background-repeat: no-repeat; background-size: cover; background-position:center; width:50%; height:200px;">
            </div>
          </div>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <h3 id="detailName"></h3>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <h5 id="detailUser"></h5>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <p class="lead" id="detailDate"></p>
        </div>
    </div>
  </div>
</div> <!--END MODAL-->

@endsection

@push('scripts')
    
<script type="text/javascript">

$('#user-table').DataTable({
    columnDefs: [
      {
        "targets": [4],
        "className": "hide_column",
        "searchable": false
      },
    ]
  });

  $(document).on('click', '.btnDetail', function(e) {
    e.preventDefault;
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var user=row.find("td:eq(2)").text();
    var date=row.find("td:eq(3)").text();
    var photo=row.find("td:eq(4)").text();
   

    $('#detailName').text(name);
    $('#detailUser').text(user);
    $('#detailDate').text(date);
    $('#detailPhoto').css("background-image", "url("+photo+")");
    //console.log("url("+photo+")");
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
    var url = "{{ route('admin.guide.index') }}/"+sid;
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