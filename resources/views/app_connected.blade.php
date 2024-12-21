<!DOCTYPE html>
<html>
<title>Affiliate Shopify APP</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css11">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.jqueryui.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.jqueryui.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.w3-black, .w3-hover-black:hover {
    color: #fff!important;
    background-color: #e3e3e3!important;
}
.w3-red, .w3-hover-red:hover {
    color: #fff!important;
    background-color: #111111!important;
}
.w3-container, .w3-panel {
    padding: 0px 16px 16px 16px;
    margin-top: 10px;
}
div#user h3 {
    margin: 20px 0 11px 0;
}
div#user tr:nth-child(even) {
    background-color: #fff;
}
.w3-bar .w3-button {
    white-space: normal;
    color: #000;
}
select#change_status {
    border: 1px #ccc solid;
    font-size: 14px;
    width: 100%;
    height: 34px;
}
tr:nth-child(even) {
    background-color: #fff;
}
.w3-red, .w3-hover-red:hover {
    color: #fff!important;
    background-color: #9b9b9b!important;
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.loading_gif {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
}

.dtrg-group.dtrg-start.dtrg-level-0 {
  display: none;
}
</style>
<body>

<div class="w3-container">
  <!-- <h2>Shopify APP</h2> -->
  <p></p>

  <div class="w3-bar w3-black">
      <button class="w3-bar-item w3-button tablink w3-red" onclick="openCity(event,'pending_user')">Pending Referral</button>
      <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'enable_user')">Affiliate</button>
    <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'app_user')">Approved Referral</button>
    <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'rejected_user')">Rejected Referral</button>
{{--    <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'rej_user')">Rejected Referral</button>--}}
      <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'user')">All Referrals</button>

      
      <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'history_log')">Log</button>
      <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'edit')">Edit</button>
  </div>
    <div id="pending_user" class="w3-container w3-border city">
        <h4>Pending Referral</h4>
        <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Affiliate Name</th>
                  <th>Referral Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Description</th>
                  <th>Credits</th>
                  <th>Commission</th>
                  <th>Referral Status</th>
                  <th>Change Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pending_users as $user)
                  <tr>
                      <td>{{$user->affiliater}}</td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->phone}}</td>
                      <td>{{$user->textarea_data}}</td>
                      <td>{{$user->points}}</td>
                      <td>{{$user->commission}}</td>
                      <td>{{$user->referral_status}}</td>
                      <td>
                          <button shid="{{$user->shopify_user_id}}" email="{{$user->email}}" value="approved" class="btn btn-primary select">Mark Accept</button>
                      </td>
                  </tr>
              @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Affiliate Name</th>
                  <th>Referral Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Description</th>
                  <th>Credits</th>
                  <th>Commission</th>
                  <th>Referral Status</th>
                  <th>Change Status</th>
            </tr>
        </tfoot>
      </table>
    </div>

    <div id="app_user" class="w3-container w3-border city" style="display:none">
    <h4>Approved Referral</h4>
    <table id="example2" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Affiliate Name</th>
            <th>Referral Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Description</th>
            <th>Credits</th>
            <th>Commission</th>
            <th>Referral Status</th>
            <th>Add Credits</th>
            <th>Add Commission</th>
        </tr>
    </thead>
    <tbody>
        @foreach($approved_users as $user)
              <tr>
                  <td id="sh_ID">{{$user->affiliater}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->textarea_data}}</td>
                  <td>{{$user->points}}</td>
                  <td>{{$user->commission}}</td>
                  <td>{{$user->referral_status}}</td>
                  <td><span sh_idd="{{$user->shopify_user_id}}" email="{{$user->email}}" class="btn btn-info btn-sm" data-toggle="modal" data-target="#creditModal">Add Credits</span></td>
                  <td><span sh_idd="{{$user->shopify_user_id}}" email="{{$user->email}}" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Add Commission</span></td>
              </tr>
          @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Affiliate Name</th>
            <th>Referral Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Description</th>
            <th>Credits</th>
            <th>Commission</th>
            <th>Referral Status</th>
            <th>Add Credits</th>
            <th>Add Commission</th>
        </tr>
    </tfoot>
  </table>
  </div>


  <div id="rejected_user" class="w3-container w3-border city" style="display:none">
    <h4>Rejected Referral</h4>
    <table id="example3" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Affiliate Name</th>
            <th>Referral Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Description</th>
            <th>Credits</th>
            <th>Commission</th>
            <th>Referral Status</th>
            <th>Add Credits</th>
            <th>Add Commission</th>
        </tr>
    </thead>
    <tbody>
        @foreach($approved_users as $user)
              <tr>
                  <td id="sh_ID">{{$user->affiliater}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->textarea_data}}</td>
                  <td>{{$user->points}}</td>
                  <td>{{$user->commission}}</td>
                  <td>{{$user->referral_status}}</td>
                  <td>-</td>
                  <td>-</td>
              </tr>
          @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Affiliate Name</th>
            <th>Referral Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Description</th>
            <th>Credits</th>
            <th>Commission</th>
            <th>Referral Status</th>
            <th>Add Credits</th>
            <th>Add Commission</th>
        </tr>
    </tfoot>
  </table>
  </div>

   {{-- <div id="rej_user" class="w3-container w3-border city" style="display:none">
    <h4>Rejected Referral</h4>
    <table>
      <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Credits</th>
        <th>Commission</th>
        <th>Referral Status</th>
      </tr>
    </table>
  </div>--}}

    <div id="user" class="w3-container w3-border city" style="display:none">
      <h4>All Referrals</h4>
      <table id="example4" class="display" style="width:100%">
      <thead>
          <tr>
                <th>Affiliate Name</th>
                <th>Referral Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Description</th>
                <th>Credits</th>
                <th>Commission</th>
                <th>Referral Status</th>
                <th>Change Status</th>
            </tr>
      </thead>
      <tbody>
          @foreach($users as $user)
                <tr>
                    <td>{{$user->affiliater}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->textarea_data}}</td>
                    <td>{{$user->points}}</td>
                    <td>{{$user->commission}}</td>
                    <td>{{$user->referral_status}}</td>
                    <td>
                        @if($user->referral_status == "approved")
                            <button shid="{{$user->shopify_user_id}}" email="{{$user->email}}" value="rejected" class="btn btn-danger select">Mark Reject</button>
                        @elseif($user->referral_status == "rejected")
                            <button shid="{{$user->shopify_user_id}}" email="{{$user->email}}" value="approved" class="btn btn-primary select">Mark Accept</button>
                        @else
                            <button shid="{{$user->shopify_user_id}}" email="{{$user->email}}" value="approved" class="btn btn-primary select">Mark Accept</button>
                            <button shid="{{$user->shopify_user_id}}" email="{{$user->email}}" value="rejected" class="btn btn-danger select">Mark Reject</button>
                        @endif
                        {{--<select name="change_status" id="change_status" >
                            <option shid="{{$user->shopify_user_id}}" email="{{$user->email}}" value="{{ $user->referral_status }}" {{ ( $user->referral_status == 'approved') ? 'selected' : '' }}>Approved
                            <option shid="{{$user->shopify_user_id}}" email="{{$user->email}}" value="{{ $user->referral_status }}" {{ ( $user->referral_status == 'pending') ? 'selected' : '' }}>Pending
                            <option shid="{{$user->shopify_user_id}}" email="{{$user->email}}" value="{{ $user->referral_status }}" {{ ( $user->referral_status == 'rejected') ? 'selected' : '' }}>Rejected
                        </select>--}}
                    </td>
                </tr>
            @endforeach
      </tbody>
      <tfoot>
          <tr>
              <th>Affiliate Name</th>
                <th>Referral Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Description</th>
                <th>Credits</th>
                <th>Commission</th>
                <th>Referral Status</th>
                <th>Change Status</th>
          </tr>
      </tfoot>
    </table>
    </div>


    <div id="enable_user" class="w3-container w3-border city" style="display:none">
        <h4>Affiliates</h4>
      <table id="example1" class="display" style="width:100%">
      <thead>
          <tr>
              <th>Affiliate Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Description</th>
                <th>Enable/Disable</th>
                <th>Vehicle Name</th>
                <th>Vehicle Image</th>
                <th>Upload Vehicle</th>
          </tr>
      </thead>
      <tbody>
          @foreach($affiliate_users as $user)
                <tr>
                    <td><a href="/referrals/{{$user->shopify_user_id}}">{{$user->name}}</a></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->textarea_data}}</td>
                    <td>
                      @if($user->tags)
                      <label class="switch">
                        <input type="checkbox" name="checkvvvvv" value="{{$user->shopify_user_id}}" checked="">
                        <span class="slider round"></span>
                      </label>
                      @else
                      <label class="switch">
                        <input type="checkbox" name="checkvvvvv" value="{{$user->shopify_user_id}}" >
                        <span class="slider round"></span>
                      </label>
                      @endif
                    </td>
                    <td>{{$user->vehicle_info}}</td>
                    <td>
                      @if(!empty($user->image))
                        <img src="{{url('/')}}/public/images/affiliate/{{$user->image}}" style="width: 100px;">
                      @else
                      No Image uploaded
                      @endif
                    </td>
                    <td>
                      <span class="btn btn-info btn-sm" sh_idd="{{$user->shopify_user_id}}" email="{{$user->email}}" data-toggle="modal" data-target="#vehicleModal">Add Vehicle</span>
                    </td>
                </tr>
            @endforeach
      </tbody>
      <tfoot>
          <tr>
              <th>Affiliate Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Description</th>
                <th>Enable/Disable</th>
                <th>Vehicle Name</th>
                <th>Vehicle Image</th>
                <th>Upload Vehicle</th>
          </tr>
      </tfoot>
    </table>
    </div>

    <div id="history_log" class="w3-container w3-border city" style="display:none">
        <h3>Credit History Log</h3>
        <table id="example5" class="display" style="width:100%">
        <thead>
            <tr>
            <th>Referral Email</th>
            <th>Credits</th>
            <th>Description</th>
            <th>last Updated on</th>
              </tr>
        </thead>
        <tbody>
            @foreach($credits as $credit)
                  <tr>
                      <td>{{$credit->referral_email}}</td>
                      <td>{{$credit->points}}</td>
                      <td>{{$credit->point_text}}</td>
                      <td>{{$credit->created_at}}</td>
                  </tr>
              @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Referral Email</th>
            <th>Credits</th>
            <th>Description</th>
            <th>last Updated on</th>
            </tr>
        </tfoot>
      </table>
        <br><br>
        <h3>Commissions History Log</h3>
        <table id="example6" class="display" style="width:100%">
        <thead>
            <tr>
            <th>Referral Email</th>
                  <th>Commission</th>
                  <th>Description</th>
                  <th>last Updated on</th>
              </tr>
        </thead>
        <tbody>
            @foreach($commissions as $commission)
                  <tr>
                      <td>{{$commission->referral_email}}</td>
                      <td>{{$commission->commission_val}}</td>
                      <td>{{$commission->commission_text}}</td>
                      <td>{{$commission->created_at}}</td>
                  </tr>
              @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Referral Email</th>
                  <th>Commission</th>
                  <th>Description</th>
                  <th>last Updated on</th>
            </tr>
        </tfoot>
      </table>
    </div>


    <div id="edit" class="w3-container w3-border city" style="display:none">
        <h4>Affiliate panel</h4>
        <form action="{{ route("update-panel") }}" method="GET">
            @csrf
            <input name="shop_id" type="hidden" value="{{$store->id}}">
            <div class="form-group">
                <label for="email">Affiliate panel text:</label>
                <textarea type="text" class="form-control" placeholder="Enter Text which will be shown on affiliater's panel" name="affiliate_panel_text">{{$store->panel_text}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Commission</h4>
        </div>
        <div class="modal-body">
          <form id="commission_form" enctype="multipart/form-data" action="https://shopiyreward.webgarh.net/update-commission">
            {{ csrf_field() }}
            <label for="commission"><span id="red"></span>Commission</label>
            <input type="number" id="commission" name="commission" required="">
            <br>
            <label for="textarea">Text:</label>
            <textarea id="commission_text" name="commission_text" rows="4" cols="50" required="">
              Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </textarea> 
            <br>
            <!-- <label for="cm"><span id="cm"></span>Upload Image</label>
            <input type="file" id="commission_file" name='commission_file'><br> -->
            <button class="btn btn-success" id="submit">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End -->


  <!-- creditModal -->
  <div class="modal fade" id="creditModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Credits</h4>
        </div>
        <div class="modal-body">
          <form id="credits_form" enctype="multipart/form-data" action="https://shopiyreward.webgarh.net/update-credits" >
            {{ csrf_field() }}
            <label for="points"><span id="red"></span>Credits</label>
            <input type="number" id="points" name="points" required="">
            <br>
            <label for="textarea">Text:</label>
            <textarea id="points_text" name="points_text" rows="4" cols="50" required="">
              Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </textarea> 
            <br>
            <!-- <label for="cr"><span id="cr"></span>Upload Image</label>
            <input type="file" id="credits_file" name='credits_file' required=""><br> -->
            <button class="btn btn-success" id="submit">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End -->


  <!-- Vehicla Modal -->
  <div class="modal fade" id="vehicleModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Vehicle Info</h4>
      </div>
      <div class="modal-body">
        <form name="photo" id="imageUploadForm" enctype="multipart/form-data" action="https://shopiyreward.webgarh.net/upload-image" method="post">
          {{ csrf_field() }}
          <input type="hidden" id="filecount" value='0'>
          <!-- <input type="hidden" id="shopify_user_id" name="shopify_user_id" value="{{$user->shopify_user_id}}"> -->
          <label for="vehicle"><span id="red"></span>Upload Vehicle Image</label>
          <input type="file" id="file" name='file' id="ImageBrowse" required=""><br>

          <label for="textarea">Vehicle Name:</label>
          <input type="text" id="vehicle_info" name="vehicle_info" required="">
          <!-- <textarea id="vehicle_info" name="vehicle_info" rows="4" cols="50">
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
          </textarea>  -->
          <br>
          <input type="submit" name="upload" value="Save" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      <div class="loading_gif" style="display: none;">
          <img src="https://shopiyreward.webgarh.net/public/images/affiliate/4V0b.gif">
        </div>
    </div>
  </div>
</div>
<!-- End Vehicle Modal -->

</div>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.jqueryui.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable( {
      order: [[2, 'asc']],
      rowGroup: {
          dataSrc: 2
      }
    });
    $('#example1').DataTable( {
      order: [[2, 'asc']],
      rowGroup: {
          dataSrc: 2
      }
    });
    $('#example2').DataTable( {
      order: [[2, 'asc']],
      rowGroup: {
          dataSrc: 2
      }
    });
    $('#example3').DataTable( {
      order: [[2, 'asc']],
      rowGroup: {
          dataSrc: 2
      }
    });
    $('#example4').DataTable( {
      order: [[2, 'asc']],
      rowGroup: {
          dataSrc: 2
      }
    });
    $('#example5').DataTable( {
      order: [[2, 'asc']],
      rowGroup: {
          dataSrc: 2
      }
    });
    $('#example6').DataTable( {
      order: [[2, 'asc']],
      rowGroup: {
          dataSrc: 2
      }
    });
  });
</script>

<script>
function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " w3-red";
}
</script>
<script type="text/javascript">
  $('.select').on('click', function() {
    var Status = $(this).attr('value');
    console.log(Status);
    swal({
      title: "Are you sure?",
      text: "You want to Accept",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        var selected_val1 = $(this).attr('shid');
        var email = $(this).attr('email');
        var Status = $(this).attr('value');
        var request;
        console.log('THERE..!');
        if(request){
          request.abort();
        }
        var serializedData = {
          'status_'     : Status,
          'shid'        : selected_val1,
          'email_'      : email
        };
        request = $.ajax({
          url: "https://shopiyreward.webgarh.net/update-status",
          type: "get",
          data: serializedData
        });
        request.done(function (response, textStatus, jqXHR){
          //swal("Success", 'Status updated', "success");
          swal("User status updated", {
            icon: "success",
          });
          setTimeout(function(){
            location.reload();
          }, 1000);
        });
        request.fail(function (response){
          console.log(response)
        });
        request.always(function () {
          //console.log('Running..!');
        });
      } else {
        swal("You want to Deny Request");
      }
    });
  });

  $(".btn.btn-info.btn-sm").click(function(){
    //console.log($(this).attr('sh_idd'))
    //console.log($(this).attr('email'))
    localStorage.setItem("shopify_user_id", $(this).attr('sh_idd'));
    localStorage.setItem("_emaiL", $(this).attr('email'));
    //console.log($(this).attr('sh_idd'));
  });

  var request;
  $("#commission_form").submit(function(event){
    event.preventDefault();

    //console.log(localStorage.getItem("shopify_user_id"))
    //console.log(localStorage.getItem("_emaiL"))

    var form = $('#commission_form')[0];
    var formData = new FormData(form);
    formData.append('shopify_user_id', localStorage.getItem("shopify_user_id"));
    formData.append('emaiL_', localStorage.getItem("_emaiL"));
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
      }
    });
    $.ajax({
      url: $(this).attr('action'),
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
      success: function (data) {
        console.log(data);
        swal("Success", data.message, "success");
        setTimeout(function(){
          location.reload();
        }, 1000);
      },
      error: function () {
        swal("Success", data, "success");
      }
    });


    //console.log(localStorage.getItem("shopify_user_id"));
    /*if(request){
      request.abort();
    }
    var commission = $("#commission").val();
    var commissionText = $("#commission_text").val();
    var serializedData = {
      'commission_'     : commission,
      'shopify_user_id' : localStorage.getItem("shopify_user_id"),
      'emaiL_' : localStorage.getItem("_emaiL"),
      'commission_Text' : commissionText
    };
    request = $.ajax({
      url: "https://shopiyreward.webgarh.net/update-commission",
      type: "get",
      data: serializedData
    });
    request.done(function (response, textStatus, jqXHR){
      swal("Success", 'Points updated', "success");
      setTimeout(function(){
        location.reload();
      }, 1000);
    });
    request.fail(function (response){
      console.log(response)
    });
    request.always(function () {
      //console.log('Running..!');
    });*/
  });


  var request;
  $("#credits_form").submit(function(event){
    event.preventDefault();
    
    //console.log(localStorage.getItem("shopify_user_id"))
    //console.log(localStorage.getItem("_emaiL"))

    var form = $('#credits_form')[0];
    var formData = new FormData(form);
    formData.append('shopify_user_id', localStorage.getItem("shopify_user_id"));
    formData.append('emaiL_', localStorage.getItem("_emaiL"));
    // Set header if need any otherwise remove setup part
    //console.log(formData)
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
      }
    });
    $.ajax({
        url: $(this).attr('action'),
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
          console.log(data);
          swal("Success", data.message, "success");
          setTimeout(function(){
            //location.reload();
          }, 1000);
        },
        error: function () {
          swal("Success", data, "success");
        }
    });


    //console.log(localStorage.getItem("shopify_user_id"));
    /*if(request){
      request.abort();
    }
    var points = $("#points").val();
    var pointText = $("#points_text").val();
    var serializedData = {
      'ponts_'     : points,
      'shopify_user_id' : localStorage.getItem("shopify_user_id"),
      'emaiL_' : localStorage.getItem("_emaiL"),
      'point_text' : pointText
    };
    request = $.ajax({
      url: "https://shopiyreward.webgarh.net/update-credits",
      type: "get",
      data: serializedData
    });
    request.done(function (response, textStatus, jqXHR){
      swal("Success", 'Credits updated', "success");
      setTimeout(function(){
        //location.reload();
      }, 1000);
    });
    request.fail(function (response){
      console.log(response)
    });
    request.always(function () {
      //console.log('Running..!');
    });*/



  });

</script>

<script>
$(document).ready(function(){
  $('input[type="checkbox"]').click(function(){
    if($(this).prop("checked") == true){
      console.log("Checkbox is checked." + $(this).val());
      var ID = $(this).val();
      var status = "enable";
      runAjax(ID,status);
    }
    else if($(this).prop("checked") == false){
      console.log("Checkbox is unchecked." + $(this).val());
      var ID = $(this).val();
      var status = "disable";
      runAjax(ID,status);
    }
  });
});
  
  var request;
  function runAjax(ID,status){
    if(request){
      request.abort();
    }
    var _ID = ID;
    var _status = status;
    var serializedData = {
      'id_'     : _ID,
      'status_' : _status
    };
    request = $.ajax({
      url: "https://shopiyreward.webgarh.net/update-customer-tag",
      type: "get",
      data: serializedData
    });
    request.done(function (response, textStatus, jqXHR){
      swal("Success", 'Points updated', "success");
      setTimeout(function(){
        location.reload();
      }, 1000);
    });
    request.fail(function (response){
      console.log(response)
    });
    request.always(function () {
      //console.log('Running..!');
    });
  }
</script>

<script type="text/javascript">
  jQuery( document ).ready( function( $ ) {
    $( '#imageUploadForm' ).on('submit', function(e) {
        e.preventDefault();
        $('.loading_gif').show();
        //console.log(localStorage.getItem("shopify_user_id"))
        var form = $('#imageUploadForm')[0];
        var formData = new FormData(form);
        formData.append('shopify_user_id', localStorage.getItem("shopify_user_id"));
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
              //console.log(data);
              $('.loading_gif').hide();
              swal("Success", data, "success");
              setTimeout(function(){
                location.reload();
              }, 1000);
            },
            error: function () {
              swal("Success", data, "success");
            }
        });
    });
  });
</script>
</body>
</html>
