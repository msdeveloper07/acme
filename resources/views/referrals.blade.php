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
  <a href="https://ssr-performance.myshopify.com/admin/apps/affiliate-app-3">Back</a>
  <div id="user" class="w3-container w3-border city">
    <h4>All Referrals</h4>
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
        </tr>
    </tfoot>
  </table>
  </div>
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
  });
</script>

</body>
</html>
