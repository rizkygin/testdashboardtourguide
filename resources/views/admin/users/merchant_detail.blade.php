@extends('admin.layouts.app')

@section('content')
<div class="container bootstrap snippet">
  
    @if(Session::has('Success'))
    <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <strong>Success!</strong> {{Session::get('Success')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row align-items-end mb-3">
      <div class="col-sm-10"><h2 class="m-0">{{$data->name}}</h2></div>
      <div class="col-sm-2" style="">
        @if (!$data->merchant)
          <a class="btn btn-primary btnAdd ml-10 pull-right" style="color:#fff;" data-toggle="modal" data-target="#addPromo">Set Merchant</a>
        @endif
      </div>
    </div>

          <!-- Modal -->
      <div class="modal fade" id="addPromo" tabindex="-1" role="dialog" aria-labelledby="addPromoTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <form action="{{route('admin.setmerchant', $id)}}" method="post">
            @csrf
              <div class="modal-header">
                <h5 class="modal-title" id="addPromoTitle">Set Merchant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="promocategory" class="col-form-label">Merchant :</label>
                  <select class="form-control form-control-sm" required name="merchant_id">
                    <option selected disabled>Choose Merchant...</option>
                    @foreach ($merchants as $merchant)
                      <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    <div class="row">
  		<div class="col-sm-3"><!--left col-->
      <div class="text-center">
          <img src="{{asset('storage/'.$data->detail->photo)}}" onerror="this.onerror=null; this.src='{{asset('images/default.png')}}'" class="avatar img-circle img-thumbnail" alt="avatar" >
        <h5 style="padding-top:10px;"><span class="badge badge-success">Merchant : {{$data->merchant ? $data->merchant->name : ''}} </span></h5>
        <!--<input type="file" class="text-center center-block file-upload">-->
      </div><br>

          <!--     
          <div class="panel panel-default">
            <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
            <div class="panel-body"><a href="http://bootnipets.com">bootnipets.com</a></div>
          </div>-->

          <ul class="list-group">
            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>QR Generated : </strong></span>{{$data->qr->count()}}</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>QR Used : </strong></span>{{$data->transactions->count()}}</li>
          </ul> 
          
        </div><!--/col-3-->

    	<div class="col-sm-9">
             <div class="tab-pane" id="settings">
                  <!-- body card profile detail -->                 
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-header">
                          <h5 class="mb-0">Profile Detail</h5>
                        </div>
                        <div class="card-body" style="font-size:16px;">
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Full Name </div>
                            <div class="col-sm"> {{$data->name}} </div>
                          </div>
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Email </div>
                            <div class="col-sm"> {{$data->email}} </div>
                          </div>
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Address </div>
                            <div class="col-sm"> {{$data->detail->address}} </div>
                          </div>
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Phone Number </div>
                            <div class="col-sm"> {{$data->detail->phone_number}} </div>
                          </div>
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Occupation</div>
                            <div class="col-sm"> {{$data->detail->ocupation}} </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- sampe sini -->

                  <!-- graph body -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
                          <h5>Graph Progress</h5>
                        </div>
                          <div class="card-body" style="font-size:16px;">
                            <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Promo</th>
                                        <th>Guide Name</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                    $no = 1;
                                  @endphp
                                    @foreach($trans as $d)
                                    <tr id="{{$d->id}}"> 
                                        <td>{{ $no }}</td>
                                        <td>{{$d->qrcode->promo->item->name ." ".$d->qrcode->promo->category." " .$d->qrcode->promo->value}}</td>
                                        <td>{{$d->qrcode->user->name}}</td>
                                        <td>{{$d->trx_time}}</td>
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
               </div><!--/tab-pane-->
        </div><!--/col-9-->
    </div><!--/row-->

@endsection

@push('scripts')
    
<script type="text/javascript">

  $('#user-table').DataTable()

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