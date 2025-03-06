
<section class="content-header">
    <h1>Product /<small><a href="reports.php"><i class="fa fa-home"></i> Home</a></small></h1>
            <ol class="breadcrumb">
                <a class="btn btn-block btn-default" href="add-product.php"><i class="fa fa-plus-square"></i> Add New Product</a>
</ol>
</section>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="form-group col-md-3"><br>
                         <h4 class="box-title">Filter by Category</h4>
                          <select id='name' name="name" class='form-control'>
                          <option value=''>Select All</option>
                            <?php
                            $sql = "SELECT name FROM `category` GROUP BY name ORDER BY id"; // Modified to group by 'products' column
                             $db->sql($sql);
                            $result = $db->getResult();
                              foreach ($result as $value) {
                                  ?>
                                 <option value='<?= $value['name'] ?>'><?= $value['name'] ?></option>
                               <?php } ?>
                             </select>
                          </div>
                     </div>
                    <div  class="box-body table-responsive">
                    <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=product" data-page-list="[5, 10, 20, 50, 100, 200, 500]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "challenges-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                        <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true"> ID</th>
                                    <th data-field="category_name" data-sortable="true">Category Name</th>
                                    <th data-field="name" data-sortable="true">Product Name</th>
                                    <th data-field="unit" data-sortable="true"> Unit</th>
                                    <th data-field="measurement" data-sortable="true">Measurement</th>
                                    <th data-field="price" data-sortable="true">Price</th>
                                    <th data-field="image">Image</th>
                                    <th data-field="description" data-sortable="true">Description</th>
                                    <th data-field="ratings" data-sortable="true">Ratings</th>
                                    <th data-field="discount_percentage" data-sortable="true">Discount Percentage</th>
                                    <th data-field="mrp" data-sortable="true">MRP</th>
                                    <th  data-field="operate" data-events="actionEvents">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="separator"> </div>
        </div>
    </section>

<script>

    $('#date').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#name').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#joined_date').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
   
   

    function queryParams(p) {
        return {
            "date": $('#date').val(),
            "name": $('#name').val(),
            "joined_date": $('#joined_date').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
    
</script>