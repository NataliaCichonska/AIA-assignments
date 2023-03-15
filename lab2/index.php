<?php
require_once("functions.php");
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
  <!-- place navbar here -->
  <!-- Nav tabs -->
  <header>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="display-tab" data-bs-toggle="tab" data-bs-target="#display" type="button"
          role="tab" aria-controls="display" aria-selected="true">Display</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab"
          aria-controls="add" aria-selected="false">Add</button>
      </li>
    </ul>
  </header>
  <main>
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane active" id="display" role="tabpanel" aria-labelledby="display-tab">
        <div class="container col-12">
          <div class="row">
            <?php
            get_all_data();
            ?>
          </div>
        </div>
      </div>






      <div class="tab-pane" id="add" role="tabpanel" aria-labelledby="add-tab">


        <div class="container col-8">
          <div class="row">
            <form action="insert.php" method="post">
              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="" aria-describedby="helpId" placeholder="">
                <small id="helpId" class="form-text text-muted">Insert movie's title</small>
              </div>

              <div class="form-group">
                <label for="genres">Genres</label>
                <input type="text" class="form-control" name="genres" id="" aria-describedby="genresHelpId"
                  placeholder="">
                <small id="genresHelpId" class="form-text text-muted">Insert genres ( separated with "|" )</small>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>


      </div>
    </div>
  </main>
  <?php include("footer.php") ?>

  <script src="node_modules/jquery/dist/jquery.slim.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>