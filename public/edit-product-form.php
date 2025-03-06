<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_GET['id'])) {
	$ID = $db->escapeString($_GET['id']);
} else {
	// $ID = "";
	return false;
	exit(0);
}
if (isset($_POST['btnEdit'])) {

    $name = $db->escapeString(($_POST['name']));
    $category_id = $db->escapeString(($_POST['category_id']));
	$unit = $db->escapeString(($_POST['unit']));
	$measurement = $db->escapeString(($_POST['measurement']));
	$price = $db->escapeString(($_POST['price']));
	$description = $db->escapeString(($_POST['description']));
    $ratings = $db->escapeString(($_POST['ratings']));
    $discount_percentage = $db->escapeString(($_POST['discount_percentage']));
	$mrp = $db->escapeString(($_POST['mrp']));
    
	$sql_query = "UPDATE product SET name = '$name' , category_id = '$category_id' , unit = '$unit' , measurement = '$measurement' , price = '$price' , description = '$description' , ratings = '$ratings' , discount_percentage = '$discount_percentage' WHERE id =  $ID";
		$db->sql($sql_query);
		$result = $db->getResult();             
		if (!empty($result)) {
			$error['update_product'] = " <span class='label label-danger'>Failed</span>";
		} else {
			$error['update_product'] = " <span class='label label-success'>Product Updated Successfully</span>";
		}
		if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
			//image isn't empty and update the image
			$old_image = $db->escapeString($_POST['old_image']);
			$extension = pathinfo($_FILES["image"]["name"])['extension'];
	
			$result = $fn->validate_image($_FILES["image"]);
			$target_path = 'upload/images/';
			
			$filename = microtime(true) . '.' . strtolower($extension);
			$full_path = $target_path . "" . $filename;
			if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
				echo '<p class="alert alert-danger">Can not upload image.</p>';
				return false;
				exit();
			}
			if (!empty($old_image) && file_exists($old_image)) {
				unlink($old_image);
			}
	
			$upload_image = 'upload/images/' . $filename;
			$sql = "UPDATE product SET `image`='$upload_image' WHERE `id`='$ID'";
			$db->sql($sql);
	
			$update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}
	
			if ($update_result == 1) {
				$error['update_product'] = " <section class='content-header'><span class='label label-success'>Product updated Successfully</span></section>";
			} else {
				$error['update_product'] = " <span class='label label-danger'>Failed to update</span>";
			}
		}
	}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM product WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "product.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Product<small><a href='product.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to product</a></small></h1>
	<small><?php echo isset($error['update_product']) ? $error['update_product'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="reports.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-10">

			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_languages_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
					<div class="box-body">
                    <input type="hidden" name="old_image" value="<?php echo isset($res[0]['image']) ? $res[0]['image'] : ''; ?>">
				    	<div class="row">
					  	  <div class="form-group">
                               <div class="col-md-3">
									<label for="exampleInputEmail1">Name</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
								</div>
								<div class="col-md-3">
                                <label for="exampleInputEmail1">Select Category</label> <i class="text-danger asterik">*</i>
                                    <select id='category_id' name="category_id" class='form-control'>
                                           <option value="">--Select--</option>
                                                <?php
                                                $sql = "SELECT id,name FROM `category`";
                                                $db->sql($sql);

                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['category_id'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                                    
                                                <?php } ?>
                                    </select>
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Unit</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="unit" value="<?php echo $res[0]['unit']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Measurement</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="measurement" value="<?php echo $res[0]['measurement']; ?>">
								</div>
                            </div>
                         </div>
                         <br>
						 <div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="exampleInputFile">Image</label> <i class="text-danger asterik">*</i><?php echo isset($error['image']) ? $error['image'] : ''; ?>
                                    <input type="file" name="image" onchange="readURL(this);" accept="image/png, image/jpeg" id="image" /><br>
                                    <img id="blah" src="<?php echo $res[0]['image']; ?>" alt="" width="150" height="200" <?php echo empty($res[0]['image']) ? 'style="display: none;"' : ''; ?> />
                                </div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Price</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="price" value="<?php echo $res[0]['price']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Ratings</label><i class="text-danger asterik">*</i>
									<input type="number" step="0.01" class="form-control" name="ratings" value="<?php echo $res[0]['ratings']; ?>">
								</div>
                                <div class="col-md-3">
									<label for="exampleInputEmail1">MRP</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="mrp" value="<?php echo $res[0]['mrp']; ?>">
								</div>
                            </div>	 
						  </div>
                          <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label for="exampleInputEmail1">Discount Percentage</label><i class="text-danger asterik">*</i>
                                        <input type="number" step="0.01" class="form-control" name="discount_percentage" value="<?php echo $res[0]['discount_percentage']; ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="exampleInputEmail1">Description</label><i class="text-danger asterik">*</i>
										<textarea class="form-control" name="description"><?php echo $res[0]['description']; ?></textarea>
                                    </div>
                                </div>
                            </div>

						 
						  <br>
                     </div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btnEdit">Update</button>

					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200)
                    .css('display', 'block');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    var changeCheckbox = document.querySelector('#stock_button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#stock').val(1);

        } else {
            $('#stock').val(0);
        }
    };
</script>