<?php
require_once("functions.php");
$id = $_GET["id"];
$result = get_data($id);
$tags = get_tags($id);
while ($row = mysqli_fetch_assoc($result)) {
    $title = $row['title'];
    $movieId = $row['movieId'];
    $genres = $row['genres'];
}
$rating = get_avg_rating($id)
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
                <h4 class="card-title">
                    <?php echo
                        "$title" ?>
                </h4>
                <div class="movie-genres">
                    <h5 class="card-text">Genres:</h5>
                    <?php
                    $genres = explode("|", $genres);
                    foreach ($genres as $genre) {
                        echo $genre . "<br/>";
                    }
                    ?>
                </div>
                <div class="movie-tags">
                    <h5 class="card-text">Tags:</h5>
                    <?php
                    while ($row = mysqli_fetch_assoc($tags)) { ?>
                        <div class="tag">
                            tag:
                            <p>
                                <?php echo
                                    ($row["tag"]) ?>
                            </p>
                            <p> user ID:
                                <?php echo
                                    ($row["userId"]) ?>
                            </p>
                            <p> date:
                                <?php echo
                                    (date("m/d/Y h:i", $row["timestamp"])) ?>
                            </p>
                            <a name="" id="" class="btn btn-danger"
                                href="delete-tag.php?userId=<?php echo ($row["userId"]) ?>&movieId=<?php echo ($row["movieId"]) ?>&timestamp=<?php echo ($row["timestamp"]) ?>&tag=<?php echo ($row["tag"]) ?>"
                                role="button">Delete</a>
                        </div>
                    </div>
                <?php }
                    ?>
                    <div class="row" >
                        <div class="col-2">
                    <h5 class="card-text">Average rating: <?php echo $rating ?></h5>
                    </div>
                    <div class="col-2">
                    <a name="ratings" id="" class="btn btn-primary" href="ratings.php?id=<?php echo ($id) ?>" role="button">See all ratings</a>
                    </div>
                    </div>
                </h4>
            </div>
            <form action="insert-tag.php?movieId=<?php echo $movieId ?>" method="post" class="tag-form">
            <h5 class="card-text">Add tag:</h5>
              <div class="form-group">
                <label for="userId">userId</label>
                <input type="text" class="form-control" name="userId" id="" aria-describedby="helpId" placeholder="" required>
                <small id="helpId" class="form-text text-muted">Insert userId</small>
              </div>

              <div class="form-group">
                <label for="tag">Tag</label>
                <input type="text" class="form-control" name="tag" id="" aria-describedby="tagHelpId"
                  placeholder="" required>
                <small id="tagHelpId" class="form-text text-muted">Insert tag</small>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <form action="insert-rating.php?movieId=<?php echo $movieId ?>" method="post" class="rating-form">
            <h5 class="card-text">Add rating:</h5>
              <div class="form-group">
                <label for="userId">userId</label>
                <input type="text" class="form-control" name="userId" id="" aria-describedby="helpId" placeholder="" required>
                <small id="helpId" class="form-text text-muted">Insert userId</small>
              </div>

              <div class="form-group">
                <label for="rating">Rating</label>
                <input type="text" class="form-control" name="rating" id="" aria-describedby="ratingHelpId"
                  placeholder="" required>
                <small id="ratingHelpId" class="form-text text-muted">Insert rating</small>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>


        </div>
        </div>
    </main>
</body>

</html>