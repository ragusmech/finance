<?php 
header('Access-Control-Allow-Origin: *');  
require_once('dbconnection.php');

error_reporting(E_ALL);
// print_r($_POST);exit;
$action = $_POST['action'];
$ref = $_POST['referer'];

if($ref=='ezioaws')
{

	function validateData($data)
	{
	    $resultData = htmlspecialchars(stripslashes(trim($data)));
	    return $resultData;
	}
	//Add Category

		if($action=='addcategory')
	{

		$category = $_POST['category'];
		$subcategory = $_POST['subcategory'];
		$image = $_POST['image'];
		$status = $_POST['status'];
		$dates = date("Y-m-d");

		$carr = array();
			$sql = "select * from categories where category = '$category'";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			// print_r($carr);exit;
		
		if (count($carr) >0) 
		{

			$json['status']='failed';
			$json['message']="This data already exists";
		}
		else 
		{
			$sql = "INSERT INTO categories (category,subcategory_status,image,status,created_at) VALUES ('$category','$subcategory','$image','$status','$dates')";			
			// echo $sql;
			$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Added Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Add";
			}
			
		}
		echo json_encode($json);
	}

	if($action=='updatecategory')
	{
		$category = $_POST['category'];
		$subcategory = $_POST['subcategory'];
		$image = $_POST['image'];
		$status = $_POST['status'];
		$dates = date("Y-m-d");
		$id = $_POST['id'];
		
		
			
			$sql = "UPDATE categories SET category='$category',subcategory_status='$subcategory',image='$image',status='$status' WHERE id='$id'";
		// echo $sql;
		// exit;
		$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Updated Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Update";
			}
		
		echo json_encode($json);
	}

		if($action=='deletecategory')
	{
		$id=$_POST['id'];
		$sql = "DELETE FROM categories WHERE id='$id'";
		$msg = mysqli_query($con, $sql);
		if($msg)
		{
			$json['status']='success';
			$json['message']="Deleted Successfully";
		}
		else
		{
			$json['status']='failed';
			$json['message']="Failed to Delete";
		}
		echo json_encode($json);
	}

	//Code for plans page post display

	if($action=='selectcategory')
	{
		$s = "select * from categories";
		$res = mysqli_query($con, $s);
		$num = mysqli_num_rows($res);
		if ($num == 0) 
		{
			$json['status']='failed';
			$json['message']="No data available";
			echo json_encode($json);
		}
		else 
		{

			$carr = array();
			$sql = "select * from categories";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			$tvals = json_encode($carr);
			print_r($tvals);
		}
	}

	if($action=='editcategory')
	{
		$id = $_POST['id'];
		$ss = "select * from categories as a where a.id='$id'";
		$ress = mysqli_query($con, $ss);
		$nums = mysqli_num_rows($ress);
		if ($nums == 0) 
		{
			$json['status']='failed';
			$json['message']="No Pages Found";
			echo json_encode($json);
		}
		else 
		{
			$carrs = array();
			$sqls = "select * from categories as a where a.id='$id'";
			$selecteds = mysqli_query($con, $sqls);
			$rows = mysqli_fetch_assoc($selecteds);
		    $carrs[] = $rows;

			$tvals = json_encode($rows);
			print_r($tvals);
		}
	}

	//Add Bags

		if($action=='addbags')
	{

		$bag_count = $_POST['bag_count'];
		$status = $_POST['status'];
		$category = $_POST['category'];
		$subcategory = $_POST['subcategory'];
		$dates = date("Y-m-d");

		$carr = array();
			$sql = "select * from bags where bag_count = '$bag_count' and category_id='$category'";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			// print_r($carr);exit;
		
		if (count($carr) >0) 
		{

			$json['status']='failed';
			$json['message']="This user data already exists";
		}
		else 
		{
			$sql = "INSERT INTO bags (bag_count,category_id,subcategory_id,status,created_at) VALUES ('$bag_count','$category','$subcategory','$status','$dates')";			
			
			$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Added Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Add";
			}
			
		}
		echo json_encode($json);
	}

	if($action=='updatebags')
	{
		$bag_count = $_POST['bag_count'];
		$status = $_POST['status'];
		$category = $_POST['category'];
		$subcategory = $_POST['subcategory'];
		$dates = date("Y-m-d");
		$id = $_POST['id'];
		
		
			
			$sql = "UPDATE bags SET bag_count='$bag_count',category_id='$category',subcategory_id='$subcategory',status='$status' WHERE id='$id'";
		// echo $sql;
		// exit;
		$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Updated Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Update";
			}
		
		echo json_encode($json);
	}

		if($action=='deletebags')
	{
		$id=$_POST['id'];
		$sql = "DELETE FROM bags WHERE id='$id'";
		$msg = mysqli_query($con, $sql);
		if($msg)
		{
			$json['status']='success';
			$json['message']="Deleted Successfully";
		}
		else
		{
			$json['status']='failed';
			$json['message']="Failed to Delete";
		}
		echo json_encode($json);
	}

	//Code for plans page post display

	if($action=='selectbags')
	{
		$s = "select * from bags";
		$res = mysqli_query($con, $s);
		$num = mysqli_num_rows($res);
		if ($num == 0) 
		{
			$json['status']='failed';
			$json['message']="No data available";
			echo json_encode($json);
		}
		else 
		{

			$carr = array();
			$sql = "select * from bags";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			$tvals = json_encode($carr);
			print_r($tvals);
		}
	}

	if($action=='editbags')
	{
		$id = $_POST['id'];
		$ss = "select * from bags as a where a.id='$id'";
		$ress = mysqli_query($con, $ss);
		$nums = mysqli_num_rows($ress);
		if ($nums == 0) 
		{
			$json['status']='failed';
			$json['message']="No Pages Found";
			echo json_encode($json);
		}
		else 
		{
			$carrs = array();
			$sqls = "select * from bags as a where a.id='$id'";
			$selecteds = mysqli_query($con, $sqls);
			$rows = mysqli_fetch_assoc($selecteds);
		    $carrs[] = $rows;

			$tvals = json_encode($rows);
			print_r($tvals);
		}
	}
	// Code For SubCategory

	if($action=='addsubcategory')
	{

		$subcategory = $_POST['subcategory'];
		$status = $_POST['status'];
		$category = $_POST['category'];
		$dates = date("Y-m-d");

		$carr = array();
			$sql = "select * from subcategory where subcategory = '$subcategory' and category_id='$category'";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			// print_r($carr);exit;
		
		if (count($carr) >0) 
		{

			$json['status']='failed';
			$json['message']="This user data already exists";
		}
		else 
		{
			$sql = "INSERT INTO subcategory (subcategory,category_id,status,created_at) VALUES ('$subcategory','$category','$status','$dates')";			
			
			$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Added Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Add";
			}
			
		}
		echo json_encode($json);
	}

	if($action=='updatesubcategory')
	{
		$subcategory = $_POST['subcategory'];
		$status = $_POST['status'];
		$category = $_POST['category'];
		$dates = date("Y-m-d");
		$id = $_POST['id'];
		
		
			
			$sql = "UPDATE subcategory SET subcategory='$subcategory',category_id='$category',status='$status' WHERE id='$id'";
		// echo $sql;
		// exit;
		$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Updated Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Update";
			}
		
		echo json_encode($json);
	}

		if($action=='deletesubcategory')
	{
		$id=$_POST['id'];
		$sql = "DELETE FROM subcategory WHERE id='$id'";
		$msg = mysqli_query($con, $sql);
		if($msg)
		{
			$json['status']='success';
			$json['message']="Deleted Successfully";
		}
		else
		{
			$json['status']='failed';
			$json['message']="Failed to Delete";
		}
		echo json_encode($json);
	}

	//Code for plans page post display

	if($action=='selectsubcategory')
	{
		$s = "select * from subcategory";
		$res = mysqli_query($con, $s);
		$num = mysqli_num_rows($res);
		if ($num == 0) 
		{
			$json['status']='failed';
			$json['message']="No data available";
			echo json_encode($json);
		}
		else 
		{

			$carr = array();
			$sql = "select * from subcategory";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			$tvals = json_encode($carr);
			print_r($tvals);
		}
	}

	if($action=='editsubcategory')
	{
		$id = $_POST['id'];
		$ss = "select * from subcategory as a where a.id='$id'";
		$ress = mysqli_query($con, $ss);
		$nums = mysqli_num_rows($ress);
		if ($nums == 0) 
		{
			$json['status']='failed';
			$json['message']="No Pages Found";
			echo json_encode($json);
		}
		else 
		{
			$carrs = array();
			$sqls = "select * from subcategory as a where a.id='$id'";
			$selecteds = mysqli_query($con, $sqls);
			$rows = mysqli_fetch_assoc($selecteds);
		    $carrs[] = $rows;

			$tvals = json_encode($rows);
			print_r($tvals);
		}
	}

	//Code for Bag Size

	if($action=='addbagsize')
	{

		$bag_count = $_POST['bag_count'];
		$bag_size = $_POST['bag_size'];
		$design_count = $_POST['design_count'];
		$price = $_POST['price'];
		$status = $_POST['status'];
		$dates = date("Y-m-d");

		$carr = array();
			$sql = "select * from bag_size_details where bag_count_id = '$bag_count' and bag_size = '$bag_size'";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			// print_r($carr);exit;
		
		if (count($carr) >0) 
		{

			$json['status']='failed';
			$json['message']="This user data already exists";
		}
		else 
		{
			$sql = "INSERT INTO bag_size_details (bag_count_id,bag_size,design_count,price,status,created_at) VALUES ('$bag_count','$bag_size','$design_count','$price','$status','$dates')";			
			
			$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Added Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Add";
			}
			
		}
		echo json_encode($json);
	}

	if($action=='updatebagsize')
	{
		$bag_count = $_POST['bag_count'];
		$bag_size = $_POST['bag_size'];
		$design_count = $_POST['design_count'];
		$price = $_POST['price'];
		$status = $_POST['status'];
		$dates = date("Y-m-d");
		$id = $_POST['id'];
		
		
			
			$sql = "UPDATE bag_size_details SET bag_count_id='$bag_count',bag_size='$bag_size',design_count='$design_count',price='$price',status='$status' WHERE id='$id'";
		// echo $sql;
		// exit;
		$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Updated Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Update";
			}
		
		echo json_encode($json);
	}

		if($action=='deletebagsize')
	{
		$id=$_POST['id'];
		$sql = "DELETE FROM bag_size_details WHERE id='$id'";
		$msg = mysqli_query($con, $sql);
		if($msg)
		{
			$json['status']='success';
			$json['message']="Deleted Successfully";
		}
		else
		{
			$json['status']='failed';
			$json['message']="Failed to Delete";
		}
		echo json_encode($json);
	}

	//Code for plans page post display

	if($action=='selectbagsize')
	{
		$s = "select * from bag_size_details";
		$res = mysqli_query($con, $s);
		$num = mysqli_num_rows($res);
		if ($num == 0) 
		{
			$json['status']='failed';
			$json['message']="No data available";
			echo json_encode($json);
		}
		else 
		{

			$carr = array();
			$sql = "select * from bag_size_details";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			$tvals = json_encode($carr);
			print_r($tvals);
		}
	}

	if($action=='editbagsize')
	{
		$id = $_POST['id'];
		$ss = "select * from bag_size_details as a where a.id='$id'";
		$ress = mysqli_query($con, $ss);
		$nums = mysqli_num_rows($ress);
		if ($nums == 0) 
		{
			$json['status']='failed';
			$json['message']="No Pages Found";
			echo json_encode($json);
		}
		else 
		{
			$carrs = array();
			$sqls = "select * from bag_size_details as a where a.id='$id'";
			$selecteds = mysqli_query($con, $sqls);
			$rows = mysqli_fetch_assoc($selecteds);
		    $carrs[] = $rows;

			$tvals = json_encode($rows);
			print_r($tvals);
		}
	}

//Code for Bag Designs

	if($action=='addbagdesigns')
	{
	$category_id = $_POST['category_id'];
	$bag_count_id = $_POST['bag_count_id'];
	$size_id = $_POST['size_id'];
	$design_name = $_POST['design_name'];
    $selling_price = $_POST['selling_price'];
    $mrp_price = $_POST['mrp_price'];
    $description = $_POST['description'];
    $features = $_POST['features'];
    $front_image = $_POST['frontimgname'];
    $back_image = $_POST['backimgname'];
    $preview_image = $_POST['preimgname'];
    $status = $_POST['status'];
	$dates = date("Y-m-d");
		
	$carr = array();
	$sql = "select * from design_details where design_name = '$design_name' and category_id	= '$category_id' and bag_count_id = '$bag_count_id' and size_id = '$size_id' and design_name = '$design_name' ";
	$selected = mysqli_query($con, $sql);
	while($row = mysqli_fetch_assoc($selected))
	{
	    $carr[] = $row;
	}
	// print_r($carr);exit;
		
		if (count($carr) >0) 
		{

			$json['status']='failed';
			$json['message']="This data already exists";
		}
		else 
		{
			$sql = "INSERT INTO design_details (design_name, mrp_price, selling_price, description, features, front_image, back_image, preview_image, category_id, bag_count_id, size_id, status, created_at	) VALUES ('$design_name', '$mrp_price', '$selling_price', '$description', '$features', '$front_image', '$back_image', '$preview_image', '$category_id', '$bag_count_id', '$size_id', '$status', '$dates')";			
			echo $sql;
			$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Added Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Add";
			}
			
		}
		echo json_encode($json);
	}

	if($action=='updatebagdesigns')
	{
		$category_id = $_POST['category_id'];
		$bag_count_id = $_POST['bag_count_id'];
		$size_id = $_POST['size_id'];
		$design_name = $_POST['design_name'];
	    $selling_price = $_POST['selling_price'];
	    $mrp_price = $_POST['mrp_price'];
	    $description = $_POST['description'];
	    $features = $_POST['features'];
	    $front_image = $_POST['frontimgname'];
	    $back_image = $_POST['backimgname'];
	    $preview_image = $_POST['preimgname'];
	    $status = $_POST['status'];
		$dates = date("Y-m-d");
		$id = $_POST['id'];
		
		
			
		$sql = "UPDATE bag_size_details SET category_id='$category_id',bag_count_id='$bag_count_id',size_id='$size_id',design_name='$design_name',selling_price='$selling_price',mrp_price='$mrp_price',description='$description',features='$features',front_image='$front_image',back_image='$back_image',preview_image='$preview_image',status='$status' WHERE id='$id'";
		echo $sql;
		// exit;
		$msg = mysqli_query($con, $sql);
			if($msg)
			{
				$json['status']='success';
				$json['message']="Updated Successfully";
			}
			else
			{
				$json['status']='failed';
				$json['message']="Failed to Update";
			}
		
		echo json_encode($json);
	}

		if($action=='deletebagdesigns')
	{
		$id=$_POST['id'];
		$sql = "DELETE FROM design_details WHERE id='$id'";
		$msg = mysqli_query($con, $sql);
		if($msg)
		{
			$json['status']='success';
			$json['message']="Deleted Successfully";
		}
		else
		{
			$json['status']='failed';
			$json['message']="Failed to Delete";
		}
		echo json_encode($json);
	}

	//Code for plans page post display

	if($action=='selectbagdesigns')
	{
		$s = "select * from design_details";
		$res = mysqli_query($con, $s);
		$num = mysqli_num_rows($res);
		if ($num == 0) 
		{
			$json['status']='failed';
			$json['message']="No data available";
			echo json_encode($json);
		}
		else 
		{

			$carr = array();
			$sql = "select * from design_details";
			$selected = mysqli_query($con, $sql);
			while($row = mysqli_fetch_assoc($selected))
			{
			    $carr[] = $row;
			}
			$tvals = json_encode($carr);
			print_r($tvals);
		}
	}

	if($action=='editbagdesigns')
	{
		$id = $_POST['id'];
		$ss = "select * from design_details as a where a.id='$id'";
		$ress = mysqli_query($con, $ss);
		$nums = mysqli_num_rows($ress);
		if ($nums == 0) 
		{
			$json['status']='failed';
			$json['message']="No Pages Found";
			echo json_encode($json);
		}
		else 
		{
			$carrs = array();
			$sqls = "select * from design_details as a where a.id='$id'";
			$selecteds = mysqli_query($con, $sqls);
			$rows = mysqli_fetch_assoc($selecteds);
		    $carrs[] = $rows;

			$tvals = json_encode($rows);
			print_r($tvals);
		}
	}

}
else
{
	$json['status']='failed';
	$json['message']="Access Denied";
	echo json_encode($json);
}
?>
