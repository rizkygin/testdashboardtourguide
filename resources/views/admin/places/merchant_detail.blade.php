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
      <a class="btn btn-primary btnAdd ml-2 pull-right" style="color:#fff;" data-toggle="modal" data-target="#addItem">Add Item</a>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="addItemTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <form method="POST" enctype="multipart/form-data" action="{{route('admin.item.store')}}">
          @csrf
          <input type="hidden" name="merchant_id" value="{{$data->id}}">
          <div class="modal-header">
            <h5 class="modal-title" id="addPromoTitle">Add Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="promotitle" class="col-form-label">Name :</label>
              <input type="text" name="name" class="form-control" id="promo-name" placeholder="Item Name">
            </div>
            <div class="form-group">
              <label for="promovalue" class="col-form-label">Price :</label>
              <input type="number" name="price" class="form-control" id="value-promo" placeholder="Item Price">
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

  <!-- Modal -->
  <div class="modal fade" id="addPromo" tabindex="-1" role="dialog" aria-labelledby="addPromoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <form action="{{route('admin.promo.store')}}" method="post">
          @csrf
          <input type="hidden" name="item_id" class="form-control" id="item_id" value="">
          <div class="modal-header">
            <h5 class="modal-title" id="addPromoTitle">Add Promo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="promocategory" class="col-form-label">Category Promo:</label>
              <select name="category" class="form-control form-control-sm">
                <option selected>Choose Category...</option>
                <option value="discount">Discount</option>
                <option value="price-cut">Price Cut</option>
              </select>
            </div>
            <div class="form-group">
              <label for="promovalue" class="col-form-label">Value:</label>
              <input name="value" type="number" class="form-control" id="value-promo">
            </div>
            <div class="form-group">
              <label for="promostart" class="col-form-label">Start Date:</label>
              <input name="start_time" type="date" class="form-control" id="start-promo">
            </div>
            <div class="form-group">
              <label for="promoend" class="col-form-label">Expired Date:</label>
              <input name="end_time" type="date" class="form-control" id="expired-promo">
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
                <h5>Places Detail</h5>
              </div>
              <div class="card-body" style="font-size:16px;">
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Place Name </div>
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

  
    <!-- Modal Detail Item -->
<div class="modal fade" id="itemDetail" tabindex="-1" role="dialog" aria-labelledby="itemDetailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tourismDetailTitle">Detail Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-sm-12" style="margin-bottom:15px;">
          <div class="row justify-content-center">
            <div class="view d-flex"  id="itemPhoto" style="background-repeat: no-repeat; background-size: cover; background-position:center; width:50%; height:200px;">
            </div>
          </div>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <h3 id="itemName"></h3>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <h5 id="itemPrice">Rp. {{$data->price}}</h5>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <p class="lead" id="itemDesc">{{$data->description}}</p>
        </div>
        <!-- <div class="col-sm-12" style="text-align:center;margin-bottom:20px;">
          <a type="button" class="btn btn-success btnLocation" target="_blank" style="color:#fff"><i class="nav-icon icon-location-pin"></i></a>
        </div>  -->
    </div>
    </div>
  </div>
</div> <!--END MODAL-->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
          <h5>List Item</h5>
        </div>
        <div class="card-body" style="">
          <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Item Name</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Price (Rp)</th>
                <th style="text-align: center;">Photo</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              @php
                $no = 1;
              @endphp
              @foreach ($data->item as $item)
                <tr id="">
                    <td>{{$no}}</td>
                    <td style="text-align: center;">{{$item->name}}</td>
                    <td style="text-align: center;">{{$item->description}}</td>
                    <td style="text-align: center;">{{$item->price}}</td>
                    <td style="text-align: center;">{{asset('storage/'.$item->photo)}}</td>
                    <td style="text-align: center;">
                        <a type="button" class="btn btn-info btnShow" style="color:#fff" data-toggle="modal" data-target="#itemDetail"><i class="nav-icon icon-info"></i></a>
                        <a type="button" id="{{$item->id}}" class="btn btn-success btnPromo" style="color:#fff" data-toggle="modal" data-target="#addPromo"><i class="nav-icon icon-plus"></i></a>
                        <a type="button" id="{{$item->id}}" class="btn btn-danger btnDelete" style="color:#fff" ><i class="nav-icon icon-trash"></i></a>
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
  
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
          <h5>History Promo</h5>
        </div>
        <div class="card-body" style="font-size:16px;">

          <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="promo-table">
              <thead>
                <tr>
                  <th style="text-align: center;">No</th>
                  <th style="text-align: center;">Item</th>
                  <th style="text-align: center;">Value</th>
                  <th style="text-align: center;">Category</th>
                  <th style="text-align: center;">Description</th>
                  <th style="text-align: center;">Start Date</th>
                  <th style="text-align: center;">End Date</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $no = 1;
                @endphp
                @foreach ($promos as $promo)
                  <tr id="">
                      <td>{{$no}}</td>
                      <td style="text-align: center;">{{$promo->item->name}}</td>
                      <td style="text-align: center;">{{$promo->value}}</td>
                      <td style="text-align: center;">{{$promo->category}}</td>
                      <td style="text-align: center;">{{$promo->description}}</td>
                      <td style="text-align: center;">{{$promo->start_time}}</td>
                      <td style="text-align: center;">{{$promo->end_time}}</td>
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