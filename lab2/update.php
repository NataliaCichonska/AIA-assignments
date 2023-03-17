<?php  
require_once("functions.php");
$id = $_GET["id"];
$result = get_data($id);
while($row = mysqli_fetch_assoc($result)) {
    $title = $row['title'];
    $genres = $row['genres'];
}
?>
<!doctype html>
<html>

<head>
  <title>FIlmweb</title>
  <meta name="description" content="Film info servide">
  <meta name="keywords" content="film">
  <meta name="robots" content="noindex">
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <main>
    <div class="container col-8">
      <div class="row">
      <form action="update_movie.php?id=<?php echo $id ?>" method="post">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="" aria-describedby="helpId" value=<?php echo
                "'$title'" ?> required>
            <small id="helpId" class="form-text text-muted">Insert movie's title</small>
          </div>

          <div class="form-group">
            <label for="genres">Genres</label>
            <input type="text" class="form-control" name="genres" id="" aria-describedby="genresHelpId" value=<?php echo
                "'$genres'" ?> required>
            <small id="genresHelpId" class="form-text text-muted">Insert genres ( separated with "|" )</small>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>


    </div>
    </div>
  </main>
</body>

</html>