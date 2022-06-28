
<?php 
header('Access-Control-Allow-Origin: *');  
require_once('dbconnection.php');
$size_id = $_GET['size'];

$row1=mysqli_query($con,"select a.bag_size,b.bag_count,b.id as bag_count_id ,c.category,c.id as category_id from bag_size_details as a
 left join bags as b on b.id = a.bag_count_id
left join categories as c on c.id = b.category_id where a.id='$size_id'");
$row2=mysqli_fetch_array($row1);
$category = $row2['category'];
$bag_count = $row2['bag_count'];
$category_id = $row2['category_id'];
$bag_count_id = $row2['bag_count_id'];
$size = $row2['bag_size'];
                if ($size == 1) {
                    $bag_size = '10 X 12';
                }else if ($size == 2) {
                    $bag_size = '12 X 14';
                }else  if ($size == 3){
                    $bag_size = '12 X 4 X 14';
                }
?>
<?php include 'header.php'?>

                <main>
                    <div class="container-fluid px-4">
                        <h3 class="mt-4">Add Bag Size</h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php"><?php echo $category?></a></li>
                            <li class="breadcrumb-item"><a href="bag-list.php?category=<?php echo $category_id;?>"><?php echo $bag_count?> bags</a></li>
                            <li class="breadcrumb-item"><a href="bag-size.php?count=<?php echo $bag_count_id;?>"><?php echo $bag_size?></a></li>
                            <li class="breadcrumb-item active">Bag Sizes</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body" style="text-align: right;">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addModal">Add New</button>                            
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Size List
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Design Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Design Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="table_id">
    <?php
          
          $s = "select * from design_details";
          $res = mysqli_query($con, $s);
          $num = mysqli_num_rows($res);
          if ($num == 0) 
          {
            echo '<tr>
                        <td colspan="5">No Datas Found</td>
                      </tr>';
          }
          else 
          {

            $carr = array();
            $sql = "select * from design_details";
            $selected = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($selected))
            {
                $id = $row['id'];
                $design_name = $row['design_name'];
               /* $size = $row['bag_size'];
                if ($size == 1) {
                    $bag_size = '10 X 12';
                }else if ($size == 2) {
                    $bag_size = '12 X 14';
                }else  if ($size == 3){
                    $bag_size = '12 X 4 X 14';
                }
                $design_count = $row['design_count'];
                $price = $row['price'];*/
                $status = $row['status'];

                echo "<tr>
                        <td>$design_name</td>
                        
                        <td>$status</td>
                        <td> <button type='button' class='btn btn-warning' onclick='checkData($id)' data-toggle='modal' data-target='#editModal'>Edit 
</button>&nbsp;<button type='button' class='btn btn-danger' onclick='deleteData($id)'>Delete 
</button></td>
                        </tr>";
            }
          }

                  ?>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Bag Design</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  class="row g-3"  name="add-form" id="add-form">
    <input type="hidden" class="form-control" name="category_id" value="<?php echo $category_id?>" id="category_id" placeholder="">
    <input type="hidden" class="form-control" name="bag_count_id" value="<?php echo $bag_count_id?>" id="bag_count_id" placeholder="">
    <input type="hidden" class="form-control" name="size_id" value="<?php echo $size_id?>" id="size_id" placeholder="">

    <div class="form-group col-md-6">
        <label for="design_name">Design Name</label>
        <input type="text" class="form-control" name="design_name" id="design_name" placeholder="">
        <div style="color: red;" class="audit_error" id="design_nameErr"></div>
    </div>

    <div class="form-group col-md-6">
        <label for="mrp_price">MRP</label>
        <input type="text" class="form-control" name="mrp_price" id="mrp_price" placeholder="">
        <div style="color: red;" class="audit_error" id="mrp_priceErr"></div>
    </div>

    <div class="form-group col-md-6">
        <label for="selling_price">Selling Price</label>
        <input type="text" class="form-control" name="selling_price" id="selling_price" placeholder="">
        <div style="color: red;" class="audit_error" id="selling_priceErr"></div>
    </div>

    <div class="form-group col-md-6" >
    <label for="status">Status</label>
    <select class="form-control" name="status" id="status" >
      <option value="">Select</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
    <div style="color: red;" class="audit_error" id="statusErr"></div>
  </div>

    <div class="form-group col-md-12" style="padding-top: 20px;">
        <label for="design_name">Front Image</label>
        <input type="hidden" id='frontimgname' name="frontimgname">
        <form method="post" action="" enctype="multipart/form-data" id="myform">
            <img src="" id="frontimg" width="100" height="100" style="display: none;">
            <div >
                <input type="file" id="frontfile" name="frontfile" />
                <input type="button" class="button" value="Upload" id="front_upload">
            </div>
        </form>
        <div style="color: red;"  class="audit_error" id="frontimgnameErr"></div>
    </div>

    <div class="form-group col-md-12" style="padding-top: 20px;">
        <label for="design_name">Back Image</label>
        <input type="hidden" id='backimgname' name="backimgname">
        <form method="post" action="" enctype="multipart/form-data" id="myform">
            <img src="" id="backimg" width="100" height="100" style="display: none;">
            <div >
                <input type="file" id="backfile" name="backfile" />
                <input type="button" class="button" value="Upload" id="back_upload">
            </div>
        </form>
        <div  style="color: red;" class="audit_error" id="backimgnameErr"></div>
    </div>

    <div class="form-group col-md-12" style="padding-top: 20px;">
        <label for="design_name">Preview Image</label>
        <input type="hidden" id='preimgname' name="preimgname">
        <form method="post" action="" enctype="multipart/form-data" id="myform">
            <img src="" id="preimg" width="100" height="100" style="display: none;">
            <div >
                <input type="file" id="prefile" name="prefile" />
                <input type="button" class="button" value="Upload" id="preview_upload">
            </div>
        </form>
        <div  style="color: red;"  class="audit_error" id="preimgnameErr"></div>
    </div>
     <div class="form-group col-md-12" style="padding-top: 20px;">
        <label for="features">Features &nbsp;&nbsp;&nbsp;&nbsp;</label>
        <textarea id="features" name="features" rows="4" cols="50"></textarea>
        <div style="color: red;" class="audit_error" id="featuresErr"></div>
    </div>
     <div class="form-group col-md-12" style="padding-top: 20px;">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea>
        <!-- <input type="text" class="form-control" name="description" id="description" placeholder=""> -->
        <div style="color: red;" class="audit_error" id="descriptionErr"></div>
    </div>

 
  
  <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="close_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="validateaddForm()" id="add-submit"  class="btn btn-primary">Add</button>
      </div>
       <div id="succ-client-alert" style='color: green;padding: 6px 0px 0px 16px;'></div>
       <div id="fail-client-alert" style='color: red;padding: 6px 0px 0px 16px;'></div>
    </div>
  </div>
</div>
<!-- Edit Modal -->
 <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Bag Size</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form  class="row g-3"  name="update-form" id="update-form">
            <input type="hidden" class="form-control" name="category_id" value="<?php echo $category_id?>" id="category_id" placeholder="">
            <input type="hidden" class="form-control" name="bag_count_id" value="<?php echo $bag_count_id?>" id="bag_count_id" placeholder="">
            <input type="hidden" class="form-control" name="size_id" value="<?php echo $size_id?>" id="size_id" placeholder="">
            <input type="hidden" class="form-control" name="edit_id" id="edit_id" placeholder="">

            <div class="form-group col-md-6">
                <label for="edit_design_name">Design Name</label>
                <input type="text" class="form-control" name="edit_design_name" id="edit_design_name" placeholder="">
                <div style="color: red;" class="audit_error" id="edit_design_nameErr"></div>
            </div>

            <div class="form-group col-md-6">
                <label for="edit_mrp_price">MRP</label>
                <input type="text" class="form-control" name="edit_mrp_price" id="edit_mrp_price" placeholder="">
                <div style="color: red;" class="audit_error" id="edit_mrp_priceErr"></div>
            </div>

            <div class="form-group col-md-6">
                <label for="edit_selling_price">Selling Price</label>
                <input type="text" class="form-control" name="edit_selling_price" id="edit_selling_price" placeholder="">
                <div style="color: red;" class="audit_error" id="edit_selling_priceErr"></div>
            </div>

            <div class="form-group col-md-6" >
            <label for="edit_status">Status</label>
            <select class="form-control" name="edit_status" id="edit_status" >
              <option value="">Select</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
            <div style="color: red;" class="audit_error" id="edit_statusErr"></div>
          </div>

            <div class="form-group col-md-12" style="padding-top: 20px;">
                <label for="">Front Image </label>
                <input type="hidden" id='edit_frontimgname' name="edit_frontimgname" value="edit_frontimgname">
                <form method="post" action="" enctype="multipart/form-data" id="myform">
                    <img src="" id="edit_frontimg" width="100" height="100" style="display: none;">
                    <div >
                        <input type="file" id="edit_frontfile" name="edit_frontfile" />
                        <input type="button" class="button" value="Upload" id="edit_front_upload">
                    </div>
                </form>
                <div style="color: red;"  class="audit_error" id="edit_frontimgnameErr"></div>
            </div>

            <div class="form-group col-md-12" style="padding-top: 20px;">
                <label for="design_name">Back Image</label>
                <input type="hidden" id='edit_backimgname' name="edit_backimgname">
                <form method="post" action="" enctype="multipart/form-data" id="myform">
                    <img src="" id="edit_backimg" width="100" height="100" style="display: none;">
                    <div >
                        <input type="file" id="edit_backfile" name="edit_backfile" />
                        <input type="button" class="button" value="Upload" id="edit_back_upload">
                    </div>
                </form>
                <div  style="color: red;" class="audit_error" id="edit_backimgnameErr"></div>
            </div>

            <div class="form-group col-md-12" style="padding-top: 20px;">
                <label for="design_name">Preview Image</label>
                <input type="hidden" id='edit_preimgname' name="edit_preimgname">
                <form method="post" action="" enctype="multipart/form-data" id="myform">
                    <img src="" id="edit_preimg" width="100" height="100" style="display: none;">
                    <div >
                        <input type="file" id="edit_prefile" name="edit_prefile" />
                        <input type="button" class="button" value="Upload" id="edit_preview_upload">
                    </div>
                </form>
                <div  style="color: red;"  class="audit_error" id="edit_preimgnameErr"></div>
            </div>
             <div class="form-group col-md-12" style="padding-top: 20px;">
                <label for="edit_features">Features &nbsp;&nbsp;&nbsp;&nbsp;</label>
                <textarea id="edit_features" name="edit_features" rows="4" cols="50"></textarea>
                <div style="color: red;" class="audit_error" id="edit_featuresErr"></div>
            </div>
             <div class="form-group col-md-12" style="padding-top: 20px;">
                <label for="edit_description">Description</label>
                <textarea id="edit_description" name="edit_description" rows="4" cols="50"></textarea>
                <!-- <input type="text" class="form-control" name="edit_description" id="edit_description" placeholder=""> -->
                <div style="color: red;" class="audit_error" id="descriptionErr"></div>
            </div>

         
          
          <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="close_btn1" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="updateForm()" id="sales-submit"  class="btn btn-primary">Save changes</button>
      </div>
       <div id="succ-client-alert1" style='color: green;padding: 6px 0px 0px 16px;'></div>
        <div id="fail-client-alert1" style='color: red;padding: 6px 0px 0px 16px;'></div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function printError(elemId, hintMsg) {
        document.getElementById(elemId).innerHTML = hintMsg;
    }
    // setInterval(function(){refreshData();}, 20000);
    function refreshData(){
    // $("#table_id").load(window.location + " #table_id");
    }

    function validateaddForm()
    {
    $('#succ-client-alert').html('');
    $('#fail-client-alert').html('');
    var category_id = $('#category_id').val();
    var bag_count_id = $('#bag_count_id').val();
    var size_id = $('#size_id').val();
    var design_name = $('#design_name').val();
    var selling_price = $('#selling_price').val();
    var mrp_price = $('#mrp_price').val();
    var description = $('#description').val();
    var features = $('#features').val();
    var frontimgname = $('#frontimgname').val();
    var backimgname = $('#backimgname').val();
    var preimgname = $('#preimgname').val();
    var status = $('#status').val();

    console.log(design_name,selling_price,mrp_price,description,features,frontimgname,backimgname,preimgname,status,'vaithi')
// return false;
    var design_nameErr = mrp_priceErr = selling_priceErr = descriptionErr = featuresErr = frontimgnameErr = backimgnameErr = preimgnameErr = statusErr = true;
   
    
    if(design_name == "") {
        printError("design_nameErr", "Enter Design Name");
    } else {
            printError("design_nameErr", "");
            design_nameErr = false;
    }
    if(mrp_price == "") {
        printError("mrp_priceErr", "Enter MRP ");
    } else {
            printError("mrp_priceErr", "");
            mrp_priceErr = false;
    }
    if(selling_price == "") {
        printError("selling_priceErr", "Enter Selling Price");
    } else {
            printError("selling_priceErr", "");
            selling_priceErr = false;
    }

    if(description == "") {
        printError("descriptionErr", "Enter Description");
    } else {
            printError("descriptionErr", "");
            descriptionErr = false;
    }

    if(features == "") {
        printError("featuresErr", "Enter Features");
    } else {
            printError("featuresErr", "");
            featuresErr = false;
    }

    if(frontimgname == "") {
        printError("frontimgnameErr", "Select Front Image");
    } else {
            printError("frontimgnameErr", "");
            frontimgnameErr = false;
    }

    if(backimgname == "") {
        printError("backimgnameErr", "Select Back Image");
    } else {
            printError("backimgnameErr", "");
            backimgnameErr = false;
    }

    if(preimgname == "") {
        printError("preimgnameErr", "Select Preview Image");
    } else {
            printError("preimgnameErr", "");
            preimgnameErr = false;
    }

    if(status == '' || status == 0) {
        printError("statusErr", "Select status");
    } else {
            printError("statusErr", "");
            statusErr = false;
    }
    
    if(( design_nameErr || mrp_priceErr || selling_priceErr || descriptionErr || featuresErr || frontimgnameErr || backimgnameErr || preimgnameErr || statusErr  ) == true) {
       return false;
    } 
    else{
        $("#add-submit").prop("disabled", true);
        $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{category_id:category_id,bag_count_id:bag_count_id,size_id:size_id,design_name:design_name, mrp_price:mrp_price, selling_price:selling_price,description:description, features:features, frontimgname:frontimgname, backimgname:backimgname, preimgname:preimgname,status:status, action:"updatebagdesigns", referer:"ezioaws"},
        success: function(data)
        {
            $("#add-submit").prop("disabled", false);
            $('#add-form')[0].reset();
              var data = JSON.parse(data);

             if(data.status=="success")
            {
                $('#succ-client-alert').html(data.message);
                $('#fail-client-alert').html('');
                setTimeout(function() {
                  // $('#forgot-form').modal('hide');
                 $("#close_btn").trigger("click");
                }, 1000);
                refreshData();
            }
            else
            {
              // alert(data.message);
                $('#succ-client-alert').html('');
                $('#fail-client-alert').html(data.message);
            }
         
        }
    });
    }
}

function checkData(id){
    $('#succ-client-alert1').html('');
    $('#fail-client-alert1').html('');
    var id = id;   
       var getData;
       $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{id:id,action:"editbagdesigns", referer:"ezioaws"},
        success: function (response) {
          var responseObject = JSON.parse(response);
          $('#edit_id').val(responseObject.id);  
          $('#edit_design_name').val(responseObject.design_name);
        $('#edit_selling_price').val(responseObject.selling_price);
        $('#edit_mrp_price').val(responseObject.mrp_price);
        $('#edit_description').val(responseObject.description);
        $('#edit_features').val(responseObject.features);
        $('#edit_frontimgname').val(responseObject.front_image);
        $('#edit_backimgname').val(responseObject.back_image);
        $('#edit_preimgname').val(responseObject.preview_image);
        $('#edit_status').val(responseObject.status);

         $("#edit_frontimg").attr("src",responseObject.front_image); 
        $("#edit_frontimgname").val(responseObject.front_image); 
        $("#edit_frontimg").show(); // Display image element

         $("#edit_backimg").attr("src",responseObject.back_image); 
        $("#edit_backimgname").val(responseObject.back_image); 
        $("#edit_backimg").show(); // Display image element

         $("#edit_preimg").attr("src",responseObject.preview_image); 
        $("#edit_preimgname").val(responseObject.preview_image); 
        $("#edit_preimg").show(); // Display image element
                  // console.log(responseObject.name,"response");
          console.log(response,"response");
        }
    });
    }


function deleteData(id){
    var id = id;   
       var getData;
       $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{id:id,action:"deletebagdesigns", referer:"ezioaws"},
        success: function (response) {
          var responseObject = JSON.parse(response);
          
          // console.log(responseObject.name,"response");
          console.log(response,"response");
          refreshData();   
        }
    });
    }

    function updateForm()
    {
    $('#succ-client-alert1').html('');
    $('#fail-client-alert1').html('');
    var id = $('#edit_id').val();
    var category_id = $('#edit_category_id').val();
    var bag_count_id = $('#edit_bag_count_id').val();
    var size_id = $('#edit_size_id').val();
    var design_name = $('#edit_design_name').val();
    var selling_price = $('#edit_selling_price').val();
    var mrp_price = $('#edit_mrp_price').val();
    var description = $('#edit_description').val();
    var features = $('#edit_features').val();
    var frontimgname = $('#edit_frontimgname').val();
    var backimgname = $('#edit_backimgname').val();
    var preimgname = $('#edit_preimgname').val();
    var status = $('#edit_status').val();

    console.log(design_name,selling_price,mrp_price,description,features,frontimgname,backimgname,preimgname,status,'vaithi')
// return false;
    var edit_design_nameErr = edit_mrp_priceErr = edit_selling_priceErr = edit_descriptionErr = edit_featuresErr = edit_frontimgnameErr = edit_backimgnameErr = edit_preimgnameErr = edit_statusErr = true;
   
    
    if(design_name == "") {
        printError("edit_design_nameErr", "Enter Design Name");
    } else {
            printError("edit_design_nameErr", "");
            edit_design_nameErr = false;
    }
    if(mrp_price == "") {
        printError("edit_mrp_priceErr", "Enter MRP ");
    } else {
            printError("edit_mrp_priceErr", "");
            edit_mrp_priceErr = false;
    }
    if(selling_price == "") {
        printError("edit_selling_priceErr", "Enter Selling Price");
    } else {
            printError("edit_selling_priceErr", "");
            edit_selling_priceErr = false;
    }

    if(description == "") {
        printError("edit_descriptionErr", "Enter Description");
    } else {
            printError("edit_descriptionErr", "");
            edit_descriptionErr = false;
    }

    if(features == "") {
        printError("edit_featuresErr", "Enter Features");
    } else {
            printError("edit_featuresErr", "");
            edit_featuresErr = false;
    }

    if(frontimgname == "") {
        printError("edit_frontimgnameErr", "Select Front Image");
    } else {
            printError("edit_frontimgnameErr", "");
            edit_frontimgnameErr = false;
    }

    if(backimgname == "") {
        printError("edit_backimgnameErr", "Select Back Image");
    } else {
            printError("edit_backimgnameErr", "");
            edit_backimgnameErr = false;
    }

    if(preimgname == "") {
        printError("edit_preimgnameErr", "Select Preview Image");
    } else {
            printError("edit_preimgnameErr", "");
            edit_preimgnameErr = false;
    }

    if(status == '' || status == 0) {
        printError("edit_statusErr", "Select status");
    } else {
            printError("edit_statusErr", "");
            edit_statusErr = false;
    }
    
    if(( edit_design_nameErr || edit_mrp_priceErr || edit_selling_priceErr || edit_descriptionErr || edit_featuresErr || edit_frontimgnameErr || edit_backimgnameErr || edit_preimgnameErr || edit_statusErr  ) == true) {
       return false;
    } 
    else{
        $("#add-submit").prop("disabled", true);
        $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{category_id:category_id,bag_count_id:bag_count_id,size_id:size_id,design_name:design_name, mrp_price:mrp_price, selling_price:selling_price,description:description, features:features, frontimgname:frontimgname, backimgname:backimgname, preimgname:preimgname,status:status, action:"updatebagsize", id:id,referer:"ezioaws"},
        success: function(data)
        {
            $("#add-submit").prop("disabled", false);
            $('#add-form')[0].reset();
              var data = JSON.parse(data);

             if(data.status=="success")
            {
                $('#succ-client-alert1').html(data.message);
                $('#fail-client-alert1').html('');

                setTimeout(function() {
                  // $('#forgot-form').modal('hide');
                 $("#close_btn1").trigger("click");
                }, 1000);
                refreshData();
            }
            else
            {
              // alert(data.message);
                $('#succ-client-alert1').html('');
                $('#fail-client-alert1').html(data.message);
            }
         
        }
    });
    }
}


</script>
 <script type="text/javascript">
    
    $(document).ready(function(){

    $("#front_upload").click(function(){

        var fd = new FormData();
        var files = $('#frontfile')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'api/upload-api/front-upload.php',
            type: 'POST',
            data:fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#frontimg").attr("src",response); 
                    $("#frontimgname").val(response); 
                    $("#frontimg").show(); // Display image element
                }else{
                    alert('file not uploaded');
                }
            },
        });
    });

     $("#back_upload").click(function(){

        var fd = new FormData();
        var files = $('#backfile')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'api/upload-api/back-upload.php',
            type: 'POST',
            data:fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#backimg").attr("src",response); 
                    $("#backimgname").val(response); 
                    $("#backimg").show(); // Display image element
                }else{
                    alert('file not uploaded');
                }
            },
        });
    });

      $("#preview_upload").click(function(){

        var fd = new FormData();
        var files = $('#prefile')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'api/upload-api/preview-upload.php',
            type: 'POST',
            data:fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#preimg").attr("src",response); 
                    $("#preimgname").val(response); 
                    $("#preimg").show(); // Display image element
                }else{
                    alert('file not uploaded');
                }
            },
        });
    });
});

  </script>

   <script type="text/javascript">
    
    $(document).ready(function(){

    $("#edit_front_upload").click(function(){

        var fd = new FormData();
        var files = $('#edit_frontfile')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'api/upload-api/front-upload.php',
            type: 'POST',
            data:fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#edit_frontimg").attr("src",response); 
                    $("#edit_frontimgname").val(response); 
                    $("#edit_frontimg").show(); // Display image element
                }else{
                    alert('file not uploaded');
                }
            },
        });
    });

     $("#edit_back_upload").click(function(){

        var fd = new FormData();
        var files = $('#edit_backfile')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'api/upload-api/back-upload.php',
            type: 'POST',
            data:fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#edit_backimg").attr("src",response); 
                    $("#edit_backimgname").val(response); 
                    $("#edit_backimg").show(); // Display image element
                }else{
                    alert('file not uploaded');
                }
            },
        });
    });

      $("#edit_preview_upload").click(function(){

        var fd = new FormData();
        var files = $('#edit_prefile')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'api/upload-api/preview-upload.php',
            type: 'POST',
            data:fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#edit_preimg").attr("src",response); 
                    $("#edit_preimgname").val(response); 
                    $("#edit_preimg").show(); // Display image element
                }else{
                    alert('file not uploaded');
                }
            },
        });
    });
});

  </script>
    <?php include 'footer.php'?>
            