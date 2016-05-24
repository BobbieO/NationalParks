<?php

REQUIRE '../db_connect.php';
REQUIRE '../library/Input.php';
REQUIRE_ONCE '../library/functions.php';

function pageController($dbc) {
    $errors = [];

    try {
        $name = Input::has('name') ? Input::getString('name') : ' ';
    } catch (Exception $e1) {
        $errors[] = $e1->getMessage();
    }

    try {
        $location = Input::has('location') ? Input::getString('location') : ' ';
    } catch (Exception $e2) {
        $errors[] = $e2->getMessage();
    }

    try {
        $date_established = Input::has('date_established') ? Input::getString('date_established') : ' ';
    } catch (Exception $e3) {
        $errors[] = $e3->getMessage();
    }

    try {
        $area_in_acres = Input::has('area_in_acres') ? Input::getNumber('area_in_acres') : ' ';
    } catch (Exception $e4) {
        $errors[] = $e4->getMessage();
    }

    try {
        $description = Input::has('description') ? Input::getString('description') : ' ';
    } catch (Exception $e5) {
        $errors[] = $e5->getMessage();
    }

    if(!empty($_POST) && empty($errors)) {
        $stmt = $dbc->prepare('INSERT INTO national_parks (name, location, date_established, area_in_acres, description) 
                        VALUES (:name, :location, :date_established, :area_in_acres, :description)');

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':location', $location, PDO::PARAM_STR);
        $stmt->bindValue(':date_established', $date_established, PDO::PARAM_STR);
        $stmt->bindValue(':area_in_acres', $area_in_acres, PDO::PARAM_INT);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
    }

    $data = [];

    $data['errors'] = $errors;

    $stmt = $dbc->prepare('SELECT COUNT(*) FROM national_parks');
    $stmt->execute();
    $count = $stmt->fetchColumn();
    $totalPages = ceil($count/3);

    $data['totalPages'] = $totalPages;

    $data['page'] = Input::has('page') ? Input::get('page') : 1;

    $offset = ($data['page'] - 1) * 3; 

    $stmt = $dbc->prepare('SELECT * FROM national_parks LIMIT 3 OFFSET :offset');

    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $data['parks'] = $stmt->fetchALL(PDO::FETCH_ASSOC);

    return $data;
}
    extract(pageController($dbc));
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>National Parks</title>

    <!-- font -->
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>

     <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">

    <!-- my css -->
    <link rel="stylesheet" type="text/css" href="/css/national_parks.css">

</head>
<body>

<div class="container">
    <div class="section">
        <div class="header row valign-wrapper">
            <div class="col s3">
                <img src="/img/natParkService.jpg">
            </div>
            <div class="col s9">
                <h1 class="green-text text-darken-4">National Parks of the United States</h1>
            </div>  
        </div>
        
        <div>
            <table class="z-depth-1">
                <tr class="bold">
                    <th>Name</th>
                    <th>Location</th>
                    <th>Date Established</th>
                    <th>Acreage</th>
                    <th>Description</th>
                </tr>

                <?php foreach($parks as $park) : ?>
                    <tr><td class="bold"><?= escape($park['name']); ?></td>
                    <td><?= escape($park['location']); ?></td>
                    <td><?= escape($park['date_established']); ?></td>
                    <td><?= escape($park['area_in_acres']); ?></td>
                    <td><?= escape($park['description']); ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <div class="section">
        <div class="green-text text-darken-4 center-align">
            <?php foreach($errors as $error) : ?>
                <p><?= $error; ?></p>
            <?php endforeach; ?>
        </div>

        <div>
            <form method="POST">
            <h3 class="green-text text-darken-4 center-align">Add a Park</h3>
                <p> 
                    <label for="name">Park Name</label>
                    <input id="name" name="name" type="text" placeholder="Enter park name" REQUIRED
                    value="<?= (isset($_POST['name'])) ? $_POST['name']: ''; ?>">
                
                    <label for="location">Location</label>
                    <input id="location" name="location" type="text" placeholder="Enter location" REQUIRED
                    value="<?= (isset($_POST['location'])) ? $_POST['location']: ''; ?>">
                
                    <label for="date_established">Date Established</label>
                    <input id="date_established" name="date_established" type="text" placeholder="YYYY-MM-DD format" REQUIRED
                    value="<?= (isset($_POST['date_established'])) ? $_POST['date_established']: ''; ?>">
                 
                    <label for="area_in_acres">Acreage</label>
                    <input id="area_in_acres" name="area_in_acres" type="text" placeholder="Numbers only, no punctuation" REQUIRED
                    value="<?= (isset($_POST['area_in_acres'])) ? $_POST['area_in_acres']: ''; ?>">
                    
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Tell us about it!" REQUIRED><?= (isset($_POST['description'])) ? $_POST['description']: ''; ?></textarea>
                </p>
                <p>
                    <input class="btn btn-default green darken-4 z-depth-1" type="submit" value="Add Your Park!">
                </p>
            </form>
        </div> 
    </div> 
</div>

<div class="section">
    <footer class="center-align"> 
        <?php if($page > 1): ?> 
            <a href="/index.php" class="btn btn-default green darken-4 z-depth-2">First</a>
        <?php endif; ?>

        <?php if($page >= 2): ?> 
            <a href="?page=<?= $page - 1 ?>" class="btn btn-default green darken-4 z-depth-2">Previous</a>
        <?php endif; ?>

        <button class="btn btn-default green darken-4 z-depth-2">Page <?=$page; ?></button>
        
        <?php if($page < $totalPages ): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-default green darken-4 z-depth-2">Next</a>
        <?php endif; ?>

        <?php if($page < $totalPages ): ?>
            <a href="?page=<?= $totalPages ?>" class="btn btn-default green darken-4 z-depth-2">Last</a>
        <?php endif; ?>
    </footer>
</div>

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>        
</body>
</html>




