
<?php 
header('Access-Control-Allow-Origin: *');  
require_once('dbconnection.php');
$bag_count_id = $_GET['count'];

$row1=mysqli_query($con,"select a.*,b.category,b.id as category_id from bags as a left join categories as b on b.id = a.category_id where a.id='$bag_count_id'");
$row2=mysqli_fetch_array($row1);
$category = $row2['category'];
$bag_count = $row2['bag_count'];
$category_id = $row2['category_id'];

?>
<?php include 'header.php'?>

                <main>
                    <div class="container-fluid px-4">
                        <h3 class="mt-4">Add Bag Size</h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php"><?php echo $category?></a></li>
                            <li class="breadcrumb-item"><a href="bag-list.php?category=<?php echo $category_id;?>"><?php echo $bag_count?> bags</a></li>
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
                                            <th>Bag Count</th>
                                            <th>Bag Size</th>
                                            <th>Design Count</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Bag Count</th>
                                            <th>Bag Size</th>
                                            <th>Design Count</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="table_id">
    <?php
          
          $s = "select * from bag_size_details where bag_count_id='$bag_count_id'";
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
            $sql = "select a.id as list_id,a.*,b.* from bag_size_details as a left join bags as b on a.bag_count_id=b.id where bag_count_id='$bag_count_id'";
            $selected = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($selected))
            {
                $id = $row['list_id'];
                $bag_count = $row['bag_count'];
                $size = $row['bag_size'];
                if ($size == 1) {
                    $bag_size = '10 X 12';
                }else if ($size == 2) {
                    $bag_size = '12 X 14';
                }else  if ($size == 3){
                    $bag_size = '12 X 4 X 14';
                }
                $design_count = $row['design_count'];
                $price = $row['price'];
                $status = $row['status'];

                echo "<tr>
                        <td>$bag_count</td>
                        <td>$bag_size</td>
                        <td>$design_count</td>
                        <td>$price</td>
                        <td>$status</td>
                        <td> <button type='button' class='btn btn-warning' onclick='checkData($id)' data-toggle='modal' data-target='#editModal'>Edit 
</button>&nbsp;<button type='button' class='btn btn-danger' onclick='deleteData($id)'>Delete 
</button>&nbsp;<a  href='bag-design.php?size=$id'><button type='button' class='btn btn-danger'>Add Designs 
</button></a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Bag Size</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  class="row g-3"  name="add-form" id="add-form">
    <input type="hidden" class="form-control" name="bag_count" value="<?php echo $bag_count_id?>" id="bag_count" placeholder="">


  <div class="form-group col-md-6">
    <label for="bag_size">Bag size</label>
    <select class="form-control" name="bag_size" id="bag_size" >
      <option value="">Select</option>
      <option value="1">10 X 12</option>
      <option value="2">12 X 14</option>
      <option value="3">12 X 4 X 14</option>
    </select>
    <div style="color: red;" class="audit_error" id="bag_sizeErr"></div>
  </div>
<div class="form-group col-md-6">
    <label for="design_count">Designs Count</label>
    <input type="text" class="form-control" name="design_count" id="design_count" placeholder="">
    <div style="color: red;" class="audit_error" id="design_countErr"></div>
  </div>
  <div class="form-group col-md-6">
    <label for="price">Price</label>
    <input type="text" class="form-control" name="price" id="price" placeholder="">
    <div style="color: red;" class="audit_error" id="priceErr"></div>
  </div>
  <div class="form-group col-md-6">
    <label for="status">Status</label>
    <select class="form-control" name="status" id="status" >
      <option value="">Select</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
    <div style="color: red;" class="audit_error" id="statusErr"></div>
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
              <input type="hidden" class="form-control" name="edit_id" id="edit_id" placeholder="">
    <input type="hidden" class="form-control" name="edit_bag_count" value="<?php echo $bag_count_id?>" id="edit_bag_count" placeholder="">

  
  <div class="form-group col-md-6">
    <label for="edit_bag_size">Bag Size</label>
    <select class="form-control" name="edit_bag_size" id="edit_bag_size" >
        <option value="">Select</option>
        <option value="1">10 X 12</option>
        <option value="2">12 X 14</option>
        <option value="3">12 X 4 X 14</option>
    </select>
    <div style="color: red;" class="audit_error" id="edit_bag_sizeErr"></div>
  </div>
  <div class="form-group col-md-6">
    <label for="edit_design_count">Designs Count</label>
    <input type="text" class="form-control" name="edit_design_count" id="edit_design_count" placeholder="">
    <div style="color: red;" class="audit_error" id="edit_design_countErr"></div>
  </div>
  <div class="form-group col-md-6">
    <label for="price">Price</label>
    <input type="text" class="form-control" name="edit_price" id="edit_price" placeholder="">
    <div style="color: red;" class="audit_error" id="edit_priceErr"></div>
  </div>
  <div class="form-group col-md-6">
    <label for="status">Status</label>
    <select class="form-control" name="edit_status" id="edit_status" >
      <option value="">Select</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
    <div style="color: red;" class="audit_error" id="edit_statusErr"></div>
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
    var bag_count = $('#bag_count').val();
    var bag_size = $('#bag_size').val();
    var design_count = $('#design_count').val();
    var price = $('#price').val();
    var status = $('#status').val();

    var design_countErr = bag_sizeErr = priceErr = statusErr = true;
   
    
    if(bag_size == "") {
        printError("bag_sizeErr", "Select bag size");
    } else {
            printError("bag_sizeErr", "");
            bag_sizeErr = false;
    }

    if(design_count == "") {
        printError("design_countErr", "Enter design count");
    } else {
            printError("design_countErr", "");
            design_countErr = false;
    }

    if(price == "") {
        printError("priceErr", "Enter price");
    } else {
            printError("priceErr", "");
            priceErr = false;
    }

    if(status == '') {
        printError("statusErr", "Select status");
    } else {
            printError("statusErr", "");
            statusErr = false;
    }
    
    if(( design_countErr || bag_sizeErr || priceErr || statusErr ) == true) {
       return false;
    } 
    else{
        $("#add-submit").prop("disabled", true);
        $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{bag_count:bag_count, bag_size:bag_size, price:price,design_count:design_count, status:status, action:"addbagsize", referer:"ezioaws"},
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
       console.log(id,"vaithi");
       var getData;
       $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{id:id,action:"editbagsize", referer:"ezioaws"},
        success: function (response) {
          var responseObject = JSON.parse(response);
          $('#edit_id').val(responseObject.id);  
          // $('#edit_bag_count').val(responseObject.bag_count_id);  
          $('#edit_bag_size').val(responseObject.bag_size);  
          $('#edit_design_count').val(responseObject.design_count);  
          $('#edit_price').val(responseObject.price);  
          $('#edit_status').val(responseObject.status);  

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
        data:{id:id,action:"deletebagsize", referer:"ezioaws"},
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
    var edit_bag_count = $('#edit_bag_count').val();
    var edit_bag_size = $('#edit_bag_size').val();
    var edit_price = $('#edit_price').val();
    var edit_status = $('#edit_status').val();
    var edit_design_count = $('#edit_design_count').val();

    var edit_design_countErr = edit_bag_sizeErr = edit_priceErr = edit_statusErr = true;
   
    
    if(edit_bag_size == "") {
        printError("edit_bag_sizeErr", "Select bag size");
    } else {
            printError("edit_bag_sizeErr", "");
            edit_bag_sizeErr = false;
    }

    if(edit_design_count == "") {
        printError("edit_design_countErr", "Select Design Count");
    } else {
            printError("edit_design_countErr", "");
            edit_design_countErr = false;
    }

    if(edit_price == "" || edit_price == "0" || edit_price == "0.00") {
        printError("edit_priceErr", "Enter price");
    } else {
            printError("edit_priceErr", "");
            edit_priceErr = false;
    }

    if(edit_status == '') {
        printError("edit_statusErr", "Select status");
    } else {
            printError("edit_statusErr", "");
            edit_statusErr = false;
    }
    
    if((edit_bag_sizeErr || edit_design_countErr || edit_priceErr || edit_statusErr ) == true) {
       return false;
    } 
    else{
        $("#add-submit").prop("disabled", true);
        $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{bag_count:edit_bag_count, bag_size:edit_bag_size, design_count:edit_design_count, price:edit_price, status:edit_status,id:id, action:"updatebagsize", referer:"ezioaws"},
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
    <?php include 'footer.php'?>
            