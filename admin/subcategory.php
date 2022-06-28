
<?php 
header('Access-Control-Allow-Origin: *');  
require_once('dbconnection.php');
$category_id = $_GET['category'];
$sub_status = $_GET['status'];;
$row1=mysqli_query($con,"select * from categories as a where a.id='$category_id'");
$row2=mysqli_fetch_array($row1);
$category = $row2['category'];

?>
<?php include 'header.php'?>



                <main>
                    <div class="container-fluid px-4">
                        <h3 class="mt-4">Add Sub Category</h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php"><?php echo $category?></a></li>
                            <li class="breadcrumb-item active">Bag List</li>
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
                                            <th>Sub Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Sub Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="table_id">
    <?php
          
          $s = "select * from subcategory where category_id='$category_id'";
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
            $sql = "select * from subcategory where category_id='$category_id'";
            $selected = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($selected))
            {
                $id = $row['id'];
                $category_id = $row['category_id'];
                $subcategory = $row['subcategory'];
                $status = $row['status'];

                echo "<tr>
                        <td>$subcategory</td>
                        <td>$status</td>
                        <td> <button type='button' class='btn btn-warning' onclick='checkData($id)' data-toggle='modal' data-target='#editModal'>Edit 
</button>&nbsp;<button type='button' class='btn btn-danger' onclick='deleteData($id)'>Delete 
</button>&nbsp;<a  href='bag-list.php?category=$category_id&subcategory=$id&status=$sub_status'><button type='button' class='btn btn-danger'>Add Bags 
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
        <h5 class="modal-title" id="exampleModalLabel">Add Bags</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  class="row g-3"  name="add-form" id="add-form">
    <input type="hidden" class="form-control" name="category_id" value="<?php echo $category_id?>" id="category_id" placeholder="">
  <div class="form-group col-md-6">
    <label for="subcategory">Sub Category</label>
    <input type="text" class="form-control" name="subcategory" id="subcategory" placeholder="">
    <div style="color: red;" class="audit_error" id="subcategoryErr"></div>
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
        <h5 class="modal-title" id="exampleModalLabel">Update Bags</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  class="row g-3"  name="update-form" id="update-form">
              <input type="hidden" class="form-control" name="edit_id" id="edit_id" placeholder="">
    <input type="hidden" class="form-control" name="edit_category_id" value="<?php echo $category_id?>" id="edit_category_id" placeholder="">

  <div class="form-group col-md-6">
    <label for="edit_subcategory">Sub Category</label>
    <input type="text" class="form-control" name="edit_subcategory" id="edit_subcategory" placeholder="">
    <div style="color: red;" class="audit_error" id="edit_subcategoryErr"></div>
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
    var category = $('#category_id').val();
    var subcategory = $('#subcategory').val();
    var status = $('#status').val();

    var subcategoryErr  = statusErr = true;
   
    if(subcategory == "") {
        printError("subcategoryErr", "Enter Sub Category");
    } else {
            printError("subcategoryErr", "");
            subcategoryErr = false;
    }
    
    if(status == '') {
        printError("statusErr", "Select status");
    } else {
            printError("statusErr", "");
            statusErr = false;
    }
    
    if((subcategoryErr  || statusErr ) == true) {
       return false;
    } 
    else{
        $("#add-submit").prop("disabled", true);
        $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{subcategory:subcategory, category:category, status:status, action:"addsubcategory", referer:"ezioaws"},
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
        data:{id:id,action:"editsubcategory", referer:"ezioaws"},
        success: function (response) {
          var responseObject = JSON.parse(response);
          $('#edit_id').val(responseObject.id);  
          $('#edit_subcategory').val(responseObject.subcategory);  
          // $('#edit_category').val(responseObject.category_id);  
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
        data:{id:id,action:"deletesubcategory", referer:"ezioaws"},
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
    var edit_subcategory = $('#edit_subcategory').val();
    var edit_status = $('#edit_status').val();
    var edit_category = $('#edit_category_id').val();

    var edit_subcategoryErr  = edit_statusErr = true;
   
    if(edit_subcategory == "") {
        printError("edit_subcategoryErr", "Enter Sub Category");
    } else {
            printError("edit_subcategoryErr", "");
            edit_subcategoryErr = false;
    }


  
        if(edit_status == '') {
        printError("edit_statusErr", "Select status");
    } else {
            printError("edit_statusErr", "");
            edit_statusErr = false;
    }
    
    if((edit_subcategoryErr || edit_statusErr ) == true) {
       return false;
    } 
    else{
        $("#add-submit").prop("disabled", true);
        $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{subcategory:edit_subcategory, status:edit_status, category:edit_category,id:id, action:"updatesubcategory", referer:"ezioaws"},
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
            