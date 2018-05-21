<div class="row">
  <div class="col-lg-12">

    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Tabel <strong>Product</strong></div>

      <!-- Table -->
      <div class="table-responsive" style="padding:10px 10px;">

        <table class="table table-bordered">

          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Type</th>
              <th>Brand</th>
              <th>Year</th>
              <th>SKU</th>
              <th>Price</th>
              <th>Weight (Kg)</th>
              <th>Variant</th>
              <th width="90px"></th>
            </tr>
          </thead>

          <tbody>
            <?php 
            $n = 1;
            foreach ($inv as $key => $value) { ?>
            <tr>
              <td><?php echo $n++ ?></td>
              <td><?php echo $value['name'] ?></td>
              <td><?php echo $value['type'] ?></td>
              <td><?php echo $value['brand'] ?></td>
              <td><?php echo $value['year'] ?></td>
              <td><?php echo $value['sku'] ?></td>
              <td><?php echo number_format($value['price']) ?></td>
              <td><?php echo $value['weight'] ?></td>
              <td>
                <?php
                $variant = array();
                for ($i=1; $i <= 3; $i++) { 
                  if(!empty($value['var'.$i])){
                    $variant[] = $value['attr'.$i]." : ".$value['var'.$i];
                  }
                }
                echo implode(" - ", $variant);
                ?>
              </td>
              <td widtd="90px"><a href="<?php echo site_url('inventory/edit/'.$value['id']) ?>" class="btn btn-default">View</a></td>
            </tr>
            <?php } ?>

          </tbody>

        </table>

      </div>

      </div>

          <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Tabel <strong>Customer</strong></div>

      <!-- Table -->
      <div class="table-responsive" style="padding:10px 10px;">

        <table class="table table-bordered" >

          <thead>
            <tr>
              <th>#</th>
              <th>Username</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>City</th>
              <th>Address</th>
              <th width="90px"></th>
            </tr>
          </thead>

          <tbody>
            <?php 
            $n = 1;
            foreach ($cust as $key => $value) { ?>
            <tr>
              <td><?php echo $n++ ?></td>
              <td><?php echo $value['username_cust'] ?></td>
              <td><?php echo $value['first_name_cust'] ?> <?php echo $value['last_name_cust'] ?></td>
              <td><?php echo $value['email_cust'] ?></td>
              <td><?php echo $value['phone_cust'] ?></td>
              <td><?php echo $value['city_cust'] ?></td>
              <td><?php echo $value['address_cust'] ?></td>
              <td widtd="90px"><a href="<?php echo site_url('customer/edit/'.$value['id_cust']) ?>" class="btn btn-default">View</a></td>
            </tr>
            <?php } ?>

          </tbody>

        </table>

      </div>

      </div>

    </div>
  </div>

<script type="text/javascript">

var oTable = $("table").dataTable({
  "bDeferRender": true,
  bFilter: false, bInfo: false
});

</script>