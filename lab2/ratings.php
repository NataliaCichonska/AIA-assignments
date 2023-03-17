<?php include "header.php" ;
require_once "functions.php";

$result = get_ratings($_GET["id"]);

?>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">user</th>
      <th scope="col">rating</th>
      <th scope="col">timestamp</th>
    </tr>
  </thead>
  <tbody>
  <?php

while ($row = mysqli_fetch_assoc($result)) {
    ?>
    
 
    <tr>
      <th scope="row"><?php echo $row["userId"]?></th>
      <td><?php echo $row["rating"]?></td>
      <td><?php echo $row["timestamp"]?></td>
    </tr>
  

<?php
}

?>
</tbody>
</table>
<?php

include "footer.php";
?>