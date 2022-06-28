<?php 
header('Access-Control-Allow-Origin: *');  
require_once('dbconnection.php');

?>

<?php include 'header.php'?>
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                          <div class="card-body" style="text-align: right;">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addModal">Add New</button>                            
                            </div>                          
                        <div class="row">
                            <?php
          
          $s = "select * from categories";
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
            $sql = "select * from categories";
            $selected = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($selected))
            {
                $id = $row['id'];
                $category = $row['category'];
                $subcategory = $row['subcategory_status'];
                $status = $row['status'];
            ?>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body"><?php echo $category;?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <?php 
                                        if ($subcategory == 'Yes') {
                                            ?>
                                        <a class="small text-white stretched-link" href="subcategory.php?category=<?php echo $id;?>&status=<?php echo $subcategory;?>">View Details</a>
                                        <?php  }else{ ?>
                                        <a class="small text-white stretched-link" href="bag-list.php?category=<?php echo $id;?>&status=<?php echo $subcategory;?>">View Details</a>
                                      <?php   }
                                        ?>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                                       <span> <a class="small text-white stretched-link" onclick='checkData(<?php echo $id;?>)' data-toggle='modal' data-target='#editModal'>Edit</a></span>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div> -->
                                </div>
                                
                                    <button type='button' class='btn btn-warning' onclick='checkData(<?php echo $id;?>)' data-toggle='modal' data-target='#editModal'>Edit 
                                    </button>&nbsp;<button type='button' class='btn btn-danger' onclick='deleteData(<?php echo $id;?>)'>Delete 
                                    </button>
                                </div>
                <?php  }
            }?>           
                            
                        </div>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  class="row g-3"  name="add-form" id="add-form">
  <div class="form-group col-md-6">
    <label for="category">Category</label>
    <input type="text" class="form-control" name="category" id="category" placeholder="">
    <div style="color: red;" class="audit_error" id="categoryErr"></div>
  </div>
<div class="form-group col-md-6">
    <label for="subcategory">Sub Category</label>
    <select class="form-control" name="subcategory" id="subcategory" >
      <option value="">Select</option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select>
    <div style="color: red;" class="audit_error" id="subcategoryErr"></div>
  </div>

    <div class="form-group col-md-12" style="padding-top: 20px;">
        <label for="design_name">Image</label>
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
        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  class="row g-3"  name="update-form" id="update-form">
              <input type="hidden" class="form-control" name="edit_id" id="edit_id" placeholder="">

  <div class="form-group col-md-6">
    <label for="edit_category">Category</label>
    <input type="text" class="form-control" name="edit_category" id="edit_category" placeholder="">
    <div style="color: red;" class="audit_error" id="edit_categoryErr"></div>
  </div>
  <div class="form-group col-md-6">
    <label for="subcategory">Sub Category</label>
    <select class="form-control" name="edit_subcategory" id="edit_subcategory" >
      <option value="">Select</option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select>
    <div style="color: red;" class="audit_error" id="edit_subcategoryErr"></div>
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
                        
                    </div>
                </main>

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
    var category = $('#category').val();
    var subcategory = $('#subcategory').val();
    var frontimgname = $('#frontimgname').val();
    var status = $('#status').val();
    


    var categoryErr = subcategoryErr = frontimgnameErr = statusErr = true;
   
    if(category == "") {
        printError("categoryErr", "Enter Category");
    } else {
            printError("categoryErr", "");
            categoryErr = false;
    }
    //   console.log(category,subcategory,frontimgname,status, 'vaithi');
    // return false;

    if(subcategory == "") {
        printError("subcategoryErr", "Enter sub category");
    } else {
            printError("subcategoryErr", "");
            subcategoryErr = false;
    }

    if(frontimgname == "") {
        printError("frontimgnameErr", "Select image");
    } else {
            printError("frontimgnameErr", "");
            frontimgnameErr = false;
    }


    if(status == '') {
        printError("statusErr", "Select status");
    } else {
            printError("statusErr", "");
            statusErr = false;
    }
  
    if((categoryErr || subcategoryErr || frontimgnameErr || statusErr ) == true) {
       return false;
    } 
    else{
        $("#add-submit").prop("disabled", true);
        $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{category:category, subcategory:subcategory, image:frontimgname, status:status, action:"addcategory", referer:"ezioaws"},
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
        data:{id:id,action:"editcategory", referer:"ezioaws"},
        success: function (response) {
          var responseObject = JSON.parse(response);
          $('#edit_id').val(responseObject.id);  
          $('#edit_category').val(responseObject.category);  
          $('#edit_subcategory').val(responseObject.subcategory_status);  
          $('#edit_status').val(responseObject.status);  
        $('#edit_frontimgname').val(responseObject.image);

         $("#edit_frontimg").attr("src",responseObject.image); 
        $("#edit_frontimgname").val(responseObject.image); 
        $("#edit_frontimg").show(); // Display image element


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
        data:{id:id,action:"deletecategory", referer:"ezioaws"},
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
    var edit_category = $('#edit_category').val();
    var edit_subcategory = $('#edit_subcategory').val();
    var edit_frontimgname = $('#edit_frontimgname').val();
    var edit_status = $('#edit_status').val();

    var edit_categoryErr = edit_subcategoryErr = edit_frontimgnameErr = edit_statusErr = true;
   
    if(edit_category == "") {
        printError("edit_categoryErr", "Enter Category");
    } else {
            printError("edit_categoryErr", "");
            edit_categoryErr = false;
    }

if(edit_subcategory == "") {
        printError("edit_subcategoryErr", "Enter sub category");
    } else {
            printError("edit_subcategoryErr", "");
            edit_subcategoryErr = false;
    }

    if(edit_frontimgname == "") {
        printError("edit_frontimgnameErr", "Select image");
    } else {
            printError("edit_frontimgnameErr", "");
            edit_frontimgnameErr = false;
    }


    if(edit_status == '') {
        printError("edit_statusErr", "Select status");
    } else {
            printError("edit_statusErr", "");
            edit_statusErr = false;
    }
    
    if((edit_categoryErr || edit_subcategoryErr || edit_frontimgnameErr|| edit_statusErr ) == true) {
       return false;
    } 
    else{
        $("#add-submit").prop("disabled", true);
        $.ajax({
        url: 'api/bags-api.php',
        type: 'POST',
        data:{category:edit_category, image:edit_frontimgname,subcategory:edit_subcategory, status:edit_status,id:id, action:"updatecategory", referer:"ezioaws"},
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
            url: 'api/upload-api/category-upload.php',
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
});

  </script>

  <script type="text/javascript">
    
    $(document).ready(function(){

    $("#edit_front_upload").click(function(){

        var fd = new FormData();
        var files = $('#edit_frontfile')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'api/upload-api/category-upload.php',
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
    });

  </script>
              
<?php include 'footer.php'?>
