<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php
if (isset($_POST['btnAdd'])) {

        $name = $db->escapeString(($_POST['name']));
        $category_id = $db->escapeString(($_POST['category_id']));
        $unit = $db->escapeString(($_POST['unit']));
        $measurement = $db->escapeString(($_POST['measurement']));
        $price = $db->escapeString(($_POST['price']));
        $description = $db->escapeString(($_POST['description']));
        $ratings = $db->escapeString(($_POST['ratings']));
        $discount_percentage = $db->escapeString(($_POST['discount_percentage']));
        $mrp = $db->escapeString(($_POST['mrp']));
   
        $error = array();
       
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($unit)) {
            $error['unit'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($measurement)) {
            $error['measurement'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($price)) {
            $error['price'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($ratings)) {
            $error['ratings'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($discount_percentage)) {
            $error['discount_percentage'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($mrp)) {
            $error['mrp'] = " <span class='label label-danger'>Required!</span>";
        }
  
  
       
            // Validate and process the image upload
    if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
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

        $upload_image = 'upload/images/' . $filename;
        $sql = "INSERT INTO product (name,unit,image,measurement,price,description,ratings,discount_percentage,mrp,category_id) VALUES ('$name','$unit','$upload_image','$measurement','$price','$description','$ratings','$discount_percentage','$mrp','$category_id')";
        $db->sql($sql);
    } else {
            $sql_query = "INSERT INTO product (name,unit,measurement,price,description,ratings,discount_percentage,mrp,category_id) VALUES ('$name','$unit','$measurement','$price','$description','$ratings','$discount_percentage','$mrp','$category_id')";
            $db->sql($sql_query);
            $db->sql($sql);
        }
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                
                $error['add_languages'] = "<section class='content-header'>
                                                <span class='label label-success'>Product Added Successfully</span> </section>";
            } else {
                $error['add_languages'] = " <span class='label label-danger'>Failed</span>";
            }
     }
        
?>
<section class="content-header">
    <h1>Add New Product <small><a href='product.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Product</a></small></h1>

    <?php echo isset($error['add_languages']) ? $error['add_languages'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="reports.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form url="add-languages-form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       <div class="row">
                            <div class="form-group">
                                <div class='col-md-3'>
                                    <label for="exampleInputtitle">Name</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class='col-md-3'>
                                <label for="exampleInputEmail1">Select Category</label> <i class="text-danger asterik">*</i>
                                 <select id='category_id' name="category_id" class='form-control'>
                                           <option value="">--Select--</option>
                                                <?php
                                                $sql = "SELECT id,name FROM `category`";
                                                $db->sql($sql);

                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                    ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputtitle">Unit</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="unit">
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputtitle">Measurement</label> <i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="measurement" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                 <div class="col-md-3">
                                    <label for="exampleInputFile">Image</label> <i class="text-danger asterisk">*</i><?php echo isset($error['image']) ? $error['image'] : ''; ?>
                                    <input type="file" name="image" onchange="readURL(this);" accept="image/png, image/jpeg" id="image" required/><br>
                                    <img id="blah" src="#" alt="" style="display: none; max-height: 200px; max-width: 200px;" /> <!-- Adjust max-height and max-width as needed -->
                                 </div>
                                 <div class='col-md-3'>
                                    <label for="exampleInputtitle">Price</label> <i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="price" required>
                                </div>
                                 <div class='col-md-3'>
                                    <label for="exampleInputtitle">Ratings</label> <i class="text-danger asterik">*</i>
                                    <input type="number" step="0.01"  class="form-control" name="ratings" required>
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputtitle">MRP</label> <i class="text-danger asterik">*</i>
                                    <input type="number"  class="form-control" name="mrp" required>
                                </div>
                            </div> 
                        </div> 
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-3'>
                                    <label for="exampleInputtitle">Discount Percentage</label> <i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="discount_percentage" required>
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputtitle">Description</label> <i class="text-danger asterik">*</i>
                                    <textarea class="form-control" name="description" required></textarea>
                                </div>
                            </div>
                        </div>

                       
                        
                        <br> 
                    
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Submit</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>
                <div id="result"></div>

            </div><!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_leave_form').validate({

        ignore: [],
        debug: false,
        rules: {
        reason: "required",
            date: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('#user_id').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    });

    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            // Set the source of the image to the selected file
            document.getElementById('blah').src = e.target.result;
            // Display the image by changing its style to block
            document.getElementById('blah').style.display = 'block';
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
<?php $db->disconnect(); ?>
