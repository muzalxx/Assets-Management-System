

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Surabaya
      <small>Office</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Branch</li>
      <li class="active">Surabaya</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <?php if(in_array('deleteProduct', $user_permission)): ?>
          <a href="<?= site_url('products/generateQR') ?>" class="btn btn-primary" target="_blank"><i class="bi bi-qr-code"></i> Generate QR</a>
        <?php endif; ?>

        <?php if(in_array('createProduct', $user_permission)): ?>
          <a href="<?= site_url('products/print') ?>" class="btn btn-primary" target="_blank"><i class="bi bi-printer"></i>Print data</a>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Assets</h3>
            <div class="btn-group" role="group" aria-label="">
              <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
              <label class="btn btn-primary" for="btnradio1">All</label>
              
              <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
              <label class="btn btn-primary" for="btnradio2"><i class="bi bi-laptop"></i></label>

              <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
              <label class="btn btn-primary" for="btnradio3"><i class="bi bi-boxes"></i></label>

              <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
              <label class="btn btn-primary" for="btnradio4"><i class="bi bi-car-front"></i></label>
              
              <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
              <label class="btn btn-primary" for="btnradio5"><i class="bi bi-question-circle"></i> </label>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="overflow-x: auto;">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Image</th>
                <th>Asset Name</th> 
                <th>Asset Code</th>
                <th>Category</th>
                <th>User</th>
                <th>Price</th>
                <th>Date buy</th>
                <th>Serial Number</th>
                <th>Condition</th>
                <?php if(in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                  <th>Action</th>
                <?php endif; ?>
              </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php if(in_array('deleteProduct', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Asset</h4>
      </div>

      <form role="form" action="<?php echo base_url('products/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
          <center>
          <div id="qrImage"></div>
          </center>
          <table class="table table-bordered no-margin">
            <tbody>
                <tr>
                    <th>Image</th>
                    <td><div id="image"></div></td>
                </tr>
                <tr>
                  <th>Asset Name</th>
                  <td><span id="name"></span></td>
                </tr>
                <tr>
                  <th>Asset Code</th>
                  <td><span id="code"></span></td>
                </tr>
                <tr>
                  <th>Category</th>
                  <td><span id="category"></span></td>
                </tr>
                <tr>
                  <th>Price</th>
                  <td><span id="price"></span></td>
                </tr>
                <tr>
                  <th>Date Buy</th>
                  <td><span id="dateBuy"></span></td>
                </tr>
                <tr>
                  <th>Serial Number</th>
                  <td><span id="sn"></span></td>
                </tr>
                <tr>
                  <th>Warranty</th>
                  <td><span id="warranty"></span></td>
                </tr>
                <tr>
                  <th>Brand</th>
                  <td><span id="brand"></span></td>
                </tr>
                <tr>
                  <th>User</th>
                  <td><span id="user"></span></td>
                </tr>
                <tr>
                  <th>Branch</th>
                  <td><span id="branch"></span></td>
                </tr>
                <tr>
                  <th>Department</th>
                  <td><span id="dept"></span></td>
                </tr>
                <tr>
                  <th>Condition</th>
                  <td><div id="condition"></div></td>
                </tr>
                <tr>
                  <th>Description</th>
                  <td><div id="desc"></div></td>
                </tr>
              </tbody>
          </table>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

  $("#mainBranchNav").addClass('active');
  $("#surabayaBranchNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'branch/fetchProductSurabaya',
    'order': [],
    'sort': false,
    'searching': true
  });

  var radios = $("input[type='radio']")
  radios.on("click", function() {
    manageTable
    .columns(3)
    .search(this.value)
    .draw(); 
  });

});

// view Function for a Modal
function viewFunc(id)
{ 
  $.ajax({
    url: base_url + 'products/fetchProductDataById/'+id,
    type: 'GET',
    dataType: 'json',
    success:function(response) {

      // $("#edit_category_name").val(response.name);
      // $("#edit_active").val(response.active);

    var image = response.image;
    var item_name = response.name;
    var item_code = response.code;
    var category = $("#btnView").data("category");
    var price = response.price;
    var dateBuy = response.dateBuy;
    var serialnumber = response.serial_number;
    var warranty = response.warranty;
    var brand = $("#btnView").data("brand");
    var user = response.user;
    var branch = $("#btnView").data("branch");
    var dept = $("#btnView").data("dept");
    var cond = response.condition;
    var desc = response.description;

    // variatif variable
    if (cond == 1){
				cond = '<span class="label label-success">Good</span>';
			}else if (cond == 2){
				cond = '<span class="label label-warning">Maintenance</span>';
			}else if (cond == 3){
				cond = '<span class="label label-danger">Broken</span>';
			}else{
				cond = '<span class="label" style="background-color: #000000!important">Dispose</span>';
			}

    var show_image;
    if (image != "<p>You did not select a file to upload.</p>"){
      show_image = '<img src="'+ base_url + image +'" height="100px" width="100px" class="img-zoominout"></img>';
    }else{
      show_image = image ;
    }

    var qrCode = '<img src="'+ base_url +'products/modalQR/'+ id +'" alt="" width="150px" height="150px"></img>';

    // Output
    $('#qrImage').html(qrCode)
    $('#image').html(show_image);
    $('#name').text(item_name);
    $('#code').text(item_code);
    $('#category').text(category);
    $('#price').text(price);
    $('#dateBuy').text(dateBuy);
    $('#sn').text(serialnumber);
    $('#warranty').text(warranty);
    $('#brand').text(brand);
    $('#user').text(user);
    $('#branch').text(branch);
    $('#dept').text(dept);
    $('#condition').html(cond);
    $('#desc').html(desc);
    }
});
}

// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { product_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}

</script>
