<?php
require_once "db_connection.php";

function get_all_data()
{
  global $conn;
  $result = $conn->query("SELECT * FROM movies");
  while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="col-4">
      <div class="card border-primary">
        <div class="card-body">
          <h4 class="card-title">
            <?php echo
              ($row["title"]) ?>
          </h4>
          <h6 class="card-text">Genres:</h6>
          <?php
          $genres = explode("|", $row["genres"]);
          foreach ($genres as $genre) {
            echo $genre . " ";
          }
          ?>
          <div class="card-buttons">
            <a name="" id="" class="btn btn-primary" href="movie-details.php?id=<?php echo ($row["movieId"]) ?>"
              role="button">Details</a>
            <a name="" id="" class="btn btn-primary" href="update.php?id=<?php echo ($row["movieId"]) ?>"
              role="button">Edit</a>
            <a name="" id="" class="btn btn-danger" href="delete.php?id=<?php echo ($row["movieId"]) ?>"
              role="button">Delete</a>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
}

function get_data($id)
{
  global $conn;
  $result = $conn->query("SELECT * FROM movies where movieId=$id");
  return $result;
}

function get_tags($id)
{
  global $conn;
  $result = $conn->query("SELECT * FROM tags where movieId=$id");
  return $result;
}

function insert_data($title, $genres)
{
  global $conn;
  $q = "INSERT into movies (title,genres) values(\"$title\", \"$genres\")";
  $result = $conn->query($q);
  if ($result === TRUE) {
    echo "Record updated successfully";
    header('Location: http://localhost:8080/');
  } else {
    echo "Error updating record: " . $conn->error;
  }
}

function insert_tag($userId, $tag, $movieId)
{
  global $conn;
  $now_time = time();
  $q = "INSERT into tags (movieId,userId,tag,timestamp) values(\"$movieId\", \"$userId\", \"$tag\",\"$now_time\")";
  $result = $conn->query($q);
  if ($result === TRUE) {
    echo "<html><script> window.location.href=`http://localhost:8080/movie-details.php?id=$movieId`;</script></html>";
  } else {
    echo "Error updating record: " . $conn->error;
  }
}

function update_movie($title, $genres, $id)
{
  global $conn;
  $q = "UPDATE Movies SET title=\"$title\", genres=\"$genres\" WHERE movieId=$id";
  $result = $conn->query($q);
  if ($result === TRUE) {
    echo "Record updated successfully";
    header('Location: http://localhost:8080/');
  } else {
    echo "Error updating record: " . $conn->error;
  }
}

function delete_movie($id)
{
  global $conn;
  $q = "DELETE from Movies WHERE movieId=$id";
  $result = $conn->query($q);
  if ($result === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }
}

function delete_tag($movieId, $userId, $tagValue, $timestamp)
{
  global $conn;
  $q = "DELETE from Tags WHERE movieId=$movieId and userId=$userId and timestamp=$timestamp and tag='" . $tagValue . "' ";
  $result = $conn->query($q);
  if ($result === TRUE) {
    echo "<html><script> window.location.href=`http://localhost:8080/movie-details.php?id=$movieId`;</script></html>";
  } else {
    echo "Error updating record: " . $conn->error;
  }
}

?>