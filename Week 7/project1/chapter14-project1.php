<?php

  try{
    $connectionString = "mysql:host=localhost;dbname=book";
    $user = "root";
    $pass = "";

    $pdo = new PDO($connectionString, $user, $pass);
  }
  catch(PDOException $e){
    die($e->getMessage());
  }

  $userID = "";
  if (isset($_GET["employee"])){
    $userID = $_GET["employee"];
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chapter 14</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-orange.min.css">

    <link rel="stylesheet" href="css/styles.css">


    <script   src="https://code.jquery.com/jquery-1.7.2.min.js" ></script>

    <script src="https://code.getmdl.io/1.1.3/material.min.js"></script>

</head>

<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">

    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/left-nav.inc.php'; ?>

    <main class="mdl-layout__content mdl-color--grey-50">
        <section class="page-content">

            <div class="mdl-grid">

              <!-- mdl-cell + mdl-card -->
              <div class="mdl-cell mdl-cell--3-col card-lesson mdl-card  mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--orange">
                  <h2 class="mdl-card__title-text">Employees</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <ul class="demo-list-item mdl-list">

                         <?php
                           /* programmatically loop though employees and display each
                              name as <li> element. */
							            $result = $pdo->query("SELECT * FROM Employees ORDER BY LastName");
                          while ($row = $result->fetch()) {
								              echo '<li><a href="chapter14-project1.php?employee=' . $row['EmployeeID'] . '">' . $row['FirstName'] . ' ' . $row['LastName'] . '</a></li></br>';
                          }
                         ?>

                    </ul>
                </div>
              </div>  <!-- / mdl-cell + mdl-card -->

              <!-- mdl-cell + mdl-card -->
              <div class="mdl-cell mdl-cell--9-col card-lesson mdl-card  mdl-shadow--2dp">

                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Employee Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
                          <div class="mdl-tabs__tab-bar">
                              <a href="#address-panel" class="mdl-tabs__tab is-active">Address</a>
                              <a href="#todo-panel" class="mdl-tabs__tab">To Do</a>
                          </div>

                          <div class="mdl-tabs__panel is-active" id="address-panel">

                           <?php
                             /* display requested employee's information */
                             $result = $pdo->prepare("SELECT * FROM Employees WHERE EmployeeID=?");
                             $result->bindValue(1,$userID);
                             $result->execute();
                             $row = $result->fetch();
                             //show information
                             echo "<h1>" . $row["FirstName"] . " " . $row["LastName"] . "</br></h1>";
                             echo $row["Address"] . "</br>";
                             echo $row["City"] . ", " . $row["Region"] . "</br>";
                             echo $row["Country"] . ", " . $row["Postal"] . "</br>";
                             echo $row["Email"] . "</br>";
                           ?>


                          </div>
                          <div class="mdl-tabs__panel" id="todo-panel">

                               <?php
                                 /* retrieve for selected employee if none, display message to that effect */
                                 echo '<h1>No employee selected!</h1>';
                               ?>

                                <table class="mdl-data-table  mdl-shadow--2dp">
                                  <thead>
                                    <tr>
                                      <th class="mdl-data-table__cell--non-numeric">Date</th>
                                      <th class="mdl-data-table__cell--non-numeric">Status</th>
                                      <th class="mdl-data-table__cell--non-numeric">Priority</th>
                                      <th class="mdl-data-table__cell--non-numeric">Content</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                    <?php /*  display TODOs  */
                                    $result = $pdo->prepare("SELECT * FROM EmployeeTodo WHERE EmployeeID=? ORDER BY DateBy");
                                    $result->bindValue(1,$userID);
                                    $result->execute();
                                    while ($row = $result->fetch()) {
                                      echo "<tr>";
                                      echo "<td>" . $row['DateBy'] . "</td>";
                                      echo "<td>" . $row['Status'] . "</td>";
                                      echo "<td>" . $row['Description'] . "</td>";
                                      echo "</tr>";
                                    } ?>

                                  </tbody>
                                </table>


                          </div>
                        </div>
                    </div>


              </div>  <!-- / mdl-cell + mdl-card -->
            </div>  <!-- / mdl-grid -->

        </section>
    </main>
</div>    <!-- / mdl-layout -->

</body>
</html>
