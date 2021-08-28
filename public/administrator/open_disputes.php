<?php
require_once "../includes/admin-navigation.php";
require_once "../guest/connection.php";
?>

<!--  -->


  <script>
    document.title="Admin-opened disputes";
</script>


 <!-- Contents-->
 <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Opened disputes </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="./">Home</a>
              </li>
              <li class="breadcrumb-item">Disputes</li>
              <li class="breadcrumb-item active" aria-current="page">Open disputes </li>
            </ol>
          </div>
          <div class="row">
           
            <div class="col-lg-12">
              <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">List of opened disputes</h6>
                </div>
                <div class="card-body">
<!--  -->
                <!--  -->
                <div class="table table-responsive mt-3">

               <table id = "table" class = "table table-bordered table-striped">
                  <thead>
                     <tr>
                       <th>No</th>
                       <th>Dispute Id</th>
                        <th>Dispute Date</th>
                        <th>project Id</th>
                        <th>Project Title</th>
                        <th>project price</th>
                        <th>service provider</th>
                        <th>service seeker </th>
                        <th>raised by</th>
                        <th>view dispute</th>
                        <th>review dispute</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $query = $con->query("SELECT * FROM offeredproject") or die(mysqli_error($con));
                        while ($fetch = $query->fetch_array()) {
                            ?>	
                     <tr>

                     <td><?php echo $fetch['No']?></td>
                        <td><?php echo $fetch['pid']?></td>
                        <td><?php echo $fetch['ptitle']?></td>
                        <td><?php echo $fetch['odate']?></td>
                        <td><?php echo $fetch['pbudget']?></td>
                        <td><?php echo $fetch['status']?></td>   
                        <td><?php echo $fetch['status']?></td>          
                        <td><?php echo $fetch['status']?></td>
                        <td><?php echo $fetch['status']?></td>                 
                     
                        </td>
                        <td><a class = "btn btn-primary btn-sm" href = "edit_room.php?room_id=<?php echo $fetch['room_id']?>">
                           <i class="fa fa-eye">view</i></a> 
                        </td>
                        <td><a class = "btn btn-primary btn-sm" href = "edit_room.php?room_id=<?php echo $fetch['room_id']?>">
                           <i class="fa fa-eye">view</i></a> 
                        </td>
                       
                       
                     </tr>
                     <?php
                        }
                        ?>	
                  </tbody>
               </table>
            </div>
            <!--  -->
         </div>
      </div>
   </div>
</div>
 <script type = "text/javascript">
   function confirmationDelete(anchor){
   	var conf = confirm("Are you sure you want to delete this record?");
   	if(conf){
   		window.location = anchor.attr("href");
   	}
   } 
</script>
   

                </div>
              </div>
           

           
        
        


       
      <!-- Footer -->
     <?php
require_once "../includes/admin-footer.php";
     ?>

    </div>
  </div>
  <!-- Scrollto to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


<script src="../assets/vendor/jquery/jquery.min.js"></script>  
<script src="../assets/vendor/datatables/jquery.dataTables.js" ></script>
<script src="../assets/vendor/datatables/jquery.dataTables.min.js" ></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../assets/js/administrator/serelance-admin.js "></script>
<script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../assets/vendor/datatables/dataTables.bootstrap4.js" ></script>

  <script type = "text/javascript">
   $(document).ready(function(){
   	$("#table").DataTable();
   });
</script> 
  

</body>

</html>

<!--  -->