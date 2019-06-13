<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/vendors/font-awesome/all.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- endinject -->
  <style>
    #user{
      text-align: center;
      vertical-align: middle;
    }
  </style>
  <?php

    include 'header.php';
    
    $user_sql = "SELECT * FROM users";
    $data = $con->query($user_sql);
  ?>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="dashboard.php">LOGO</a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="fas fa-align-justify"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
              <i class="fa fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="index.php">
                <!-- session destroy -->
                <?php session_destroy();?>
                <i class="fa fa-sign-out-alt text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial -->
      
        <div class="main-panel">
          <?php if(isset($_SESSION['authority']) && $_SESSION['authority'] > 1) {?>
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">User management</h4>
                    <p class="card-description">
                      User edit and delete, etc.
                    </p>
                    <div class="table-responsive pt-3">
                      <table class="table table-bordered" id="user">
                        <thead>
                          <tr>
                            <th>
                              #
                            </th>
                            <th>
                              <i class="fa fa-user">
                            </th>
                            <th>
                              <i class="fa fa-lock">
                            </th>
                            <th>
                              <i class="far fa-file">
                            </th>
                            <th>
                              <i class="fas fa-pencil-alt">
                            </th>
                            <th>
                              <i class="fab fa-superpowers">
                            </th>
                            <th>
                              <i class="fa fa-trash">
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($data->num_rows > 0) {
                            // output data of each row
                            $i = 1;
                            while($row = $data->fetch_assoc()) {?>
                              <tr id="<?php echo $row['id'] ?>">
                                <td><?php echo $i++; ?> </td>
                                <td><?php echo $row['username']; ?> </td>
                                <td><?php echo $row['password']; ?> </td>
                                <?php if($row['path']==null) {?> 
                                  <td></td>
                                <?php } else {?>
                                  <td><a href="<php echo $row['path'] ?>"><i class="far fa-file"></i></a></td>
                                <?php }?>
                                <td>
                                  <button type="button" class="btn btn-info btn-rounded btn-icon edit" data-toggle="modal" data-target="#edit" data-whatever="@mdo">
                                    <i class="fas fa-pencil-alt"></i>
                                  </button>
                                </td>
                                <?php if($row['authority']==2){?>
                                  <td>admin</td>
                                <?php } else {?>
                                  <td>normal</td>
                                <?php }?>
                                <td>
                                  <button type="button" class="btn btn-danger btn-rounded btn-icon delete">
                                    <i class="fa fa-trash"></i>
                                  </button>
                                </td>
                              </tr>
                            <?php }
                          } else { ?>
                              No data
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2019 All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="far fa-heart text-danger"></i></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
      
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <form action="dashboard.php" method="post" enctype="multipart/form-data" name="myform">
  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">Edit User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        
          <div class="modal-body">
              <div class="form-group">
                <input type="hidden" id="editid" name="editid">
                <label for="username" class="col-form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control">
              </div>
              <div class="form-group">
                <label for="pwd" class="col-form-label">Password:</label>
                <input type="password" class="form-control" name="pwd" id="pwd">
              </div>
              <div class="form-group">
                <label for="fileupload" class="col-form-label">Choose File:</label>
                <input type="file" name="fileupload" id="fileupload" class="form-control">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="filepost();"  id="save" class="btn btn-success" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
          </div>
        
      </div>
    </div>
  </div>
  </form>
  <?php 
    if(isset($msg)){ // Check if $msg is not empty
      echo "<script type='text/javascript'>alert(\"$msg\");</script>"; // Display our message
    } ?>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script>
   function filepost(){
    var form = document.myform;
    var editid = form.editid.value;
    // console.log(editid);
    form.submit();
      // var username = $("#username").val();
      // var pwd = $("#pwd").val();
      // $.post('header.php',
      //   {
      //     edit_id:edit_id,
      //     username:username,
      //     pwd:pwd
      //   },
      //   function(data,status){
      //     console.log(data);
      //   }
      // );
   }
   var table = $("#user");

    //user deleting
    table.on('click', '.delete', function (e) {
      if (confirm("Are you sure to delete this user data ?") == false) {
        return;
      }

      var nRow = $(this).parents('tr')[0];
      del_id = nRow.id;
      $.post('header.php',
        {del_id:del_id},
        function(data,status){
          nRow.remove();
          alert(status);
        }
      );
    });
  
    // user editing
    table.on('click', '.edit', function (e) {
      var nRow = $(this).parents('tr')[0];
      edit_id = nRow.id;
      // console.log(edit_id);
      $.post('header.php',
        {edit_id:edit_id},
        function(data,status){
          var obj = JSON.parse(data);
          // console.log(obj[1]);
          $("#editid").val(obj[0]);
          $("#username").val(obj[1]);
          $("#pwd").val(obj[2]);
        }
      );
    });
    
    // modified user data saveing
    // $("#save").click(function(){
      // var editid = $("#editid").val();
      // var username = $("#username").val();
      // var pwd = $("#pwd").val();
      // // console.log(editid);
      // $.post('header.php',
      //   {
      //     edit_id:edit_id,
      //     username:username,
      //     pwd:pwd
      //   },
      //   function(data,status){
      //     console.log(data);
      //   }
      // );
    // });
  </script>
  <!-- End custom js for this page-->
</body>

</html>
