<!-- Php -->
<?php
$insert=false;
$update=false;
$delete=false;
$servername="localhost";
$username="root";
$password="";
$database="notes";

$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn)
{
    die("Sorry We failed to connect:".mysqli_connect_error());
}

if (isset($_GET['delete']))
{
  $sno=$_GET['delete'];
  $sql="DELETE FROM `notes` WHERE `notes`.`S.No` = '$sno' ";
$result=mysqli_query($conn,$sql);
if ($result) 
{
    $delete=true;
}
else 
{
    $err=mysqli_error($conn);
   echo "Not deleted due to this error ---> $err"; 
}
}

if($_SERVER['REQUEST_METHOD']=='POST')
{

  if(isset($_POST['snoEdit']))
  {
    //UPDATE THE record
  $title=$_POST['titleEdit'];
  $desc=$_POST['descEdit'];
  $sno=$_POST['snoEdit'];
  $sql="UPDATE `notes` SET `description` = '$desc' , `title` = '$title'  WHERE `S.No` = $sno";
  $result=mysqli_query($conn,$sql);
  if($result)
{
    $update=true;
}
else {
    echo "not updated";
}
  }
  else 
  {
  $title=$_POST['title'];
  $desc=$_POST['desc'];
  $sql="INSERT INTO `notes` (`title`, `description`, `tstamp`) VALUES ('$title', '$desc', current_timestamp())";
  $result=mysqli_query($conn,$sql);
  if ($result) 
  {
    $insert=true;
  }
  else 
  {
   echo "The Record Was Not Successfully Created because of this error --->". mysqli_error($conn);
  }
}
}
?>
<!-- HTML -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes-Notes Taking Made Easy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
   <!-- css for table -->
    <link href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- jquery for table -->
    <script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
  <!-- jquery for data Table -->
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> 
    <script>$(document).ready( function () {
    $('#myTable').DataTable();
} );</script>
</head>
  <body>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/read/crud_app.php" method="post">
      <div class="modal-body">
          <input type="text" name="snoEdit" id="snoEdit">
          <div class="mb-3 mt-4">
            <label for="title" class="form-label">Notes Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="text">
          </div>
          <div class="mb-3">
          <label for="desc" class="form-label">Notes Description</label>
          <textarea class="form-control" id="descEdit" name="descEdit" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Navbar -->
    <nav class="navbar bg-dark" data-bs-theme="dark">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/read/crud_app.php">iNotes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/read/crud_app.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
</div>
  </nav>
<!-- For Badge display -->
    <?php
    if($insert)
    {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Title <strong>$title</strong> and Description <strong>$desc</strong> is Saved.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
    }
    ?>
    <!-- For badge update -->
    <?php
    if($update)
    {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Title <strong>$title</strong> and Description <strong>$desc</strong> is Updated.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
    }
    ?>
    <!-- For badge delete -->
    <?php
    if($delete)
    {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong><b>Deleted!</b></strong> <strong>Your Note  is Deleted.</strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
    }
    ?>
<!-- Display Form  -->
</div>
<div class="container mt-4">
<h2>Add Notes</h2>
<form action="/read/crud_app.php" method="post">
  <div class="mb-3 mt-4">
    <label for="title" class="form-label">Notes Title</label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="text">
  </div>
  <div class="mb-3">
  <label for="desc" class="form-label">Notes Description</label>
  <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
</div>
  <button type="submit" class="btn btn-primary">Add Notes</button>
</form>
</div>
<!-- Table data -->
<div class="container my-4">
    <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.NO</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $sql="SELECT * FROM `notes`";
    $result=mysqli_query($conn,$sql);
    $SNo=0;
    while ($row=mysqli_fetch_assoc($result))
{
  // line 165 **** class
$SNo =$SNo+1;
   echo "<tr>
    <th scope='row'>".$SNo."</th>
    <td>".$row['title']."</td>
    <td>".$row['description']."</td>
    <td><button class='edit btn btn-sm btn-primary' id=".$row['S.No'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['S.No'].">Delete</button></td> 
  </tr>";
}
    ?>
  </tbody>
</table>
</div>
<hr>
<!-- For modal javscript -->
<script>
  // For edits
  edits=document.getElementsByClassName('edit');
  Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        desc = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, desc);
        titleEdit.value=title;
        descEdit.value=desc;
        snoEdit.value=e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
})
      })
      //For deletes
      deletes=document.getElementsByClassName('delete');
  Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno=e.target.id.substr(1,);
        if(confirm("Are You Sure To Delete This!"))
        {
          console.log("yes")
         window.location =`/read/crud_app.php?delete=${sno}`;
        }
        else
        {
          console.log("no")
        }
      })
})
  </script>
<!-- java script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>  
</body>
</html>
