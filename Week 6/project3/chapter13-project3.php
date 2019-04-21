<?php

include 'includes/book-utilities.inc.php';

$customers = readCustomers('data/customers.txt');

class Customer{
  public $customerID;
  public $name;
  public $email;
  public $university;
  public $address;
  public $city;
  public $country;
  public $sales = array();

  function __construct($id,$name,$email,$university,$address,$city,$country,$sales){
    $this->customerID = $id;
    $this->name = $name;
    $this->email = $email;
    $this->university = $university;
    $this->address = $address;
    $this->city = $city;
    $this->country = $country;
    $this->sales = $sales;
  }
}

class Order{
  public $orderID;
  public $customerID;
  public $ISBN;
  public $title;
  public $category;

  function __construct($orderID,$customerID,$ISBN,$title,$category){
    $this->orderID = $orderID;
    $this->customerID = $customerID;
    $this->ISBN = $ISBN;
    $this->title = $title;
    $this->category = $category;
  }
}

$customerArray = array();
$orderList = array();

foreach ($customers as $customer) {
  $id = $customer["id"];
  $name = $customer["name"];
  $email = $customer["email"];
  $university = $customer["university"];
  $address = $customer["address"];
  $city = $customer["city"];
  $country = $customer["country"];
  $sales = $customer["sales"];
  $customerArray[$id] = new Customer($id,$name,$email,$university,$address,$city,$country,$sales);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chapter 13</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-orange.min.css">

    <link rel="stylesheet" href="css/styles.css">


    <script   src="https://code.jquery.com/jquery-1.7.2.min.js" ></script>

    <script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
    <script src="js/jquery.sparkline.2.1.2.js"></script>

    <script type="text/javascript">
    $(function() {
        /** This code runs when everything has been loaded on the page */
        /* Inline sparklines take their values from the contents of the tag */
        $('.inlinesparkline').sparkline('html', {type: 'bar', barColor: '#6200EA'});
    });
    </script>
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
              <div class="mdl-cell mdl-cell--7-col card-lesson mdl-card  mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--orange">
                  <h2 class="mdl-card__title-text">Customers</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <table class="mdl-data-table  mdl-shadow--2dp">
                      <thead>
                        <tr>
                          <th class="mdl-data-table__cell--non-numeric">Name</th>
                          <th class="mdl-data-table__cell--non-numeric">University</th>
                          <th class="mdl-data-table__cell--non-numeric">City</th>
                          <th>Sales</th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php
                         //customer table rows are added here!
                         foreach ($customerArray as $cust) {
                           echo '<tr>';
                           echo '<td class="mdl-data-table__cell--non-numeric"><a href="chapter13-project3.php?customer=' . $cust->customerID . '">' . $cust->name . '</a></td>';
                           echo '<td class="mdl-data-table__cell--non-numeric">' . $cust->university . '</td>';
                           echo '<td class="mdl-data-table__cell--non-numeric">' . $cust->city . '</td>';
                           echo '<td><span class="inlinesparkline">' . $cust->sales . '</span></td>';
                           echo '</tr>    ';
                        }
                        ?>


                      </tbody>
                    </table>
                </div>
              </div>  <!-- / mdl-cell + mdl-card -->


            <div class="mdl-grid mdl-cell--5-col">




                 <?php
                 if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    if ( isset($_GET['customer']) ) {

                       $requestedCustomer = $customers[$_GET['customer']];
                  ?>

                  <!-- mdl-cell + mdl-card -->
                  <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card  mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Customer Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <h4><?php echo $requestedCustomer['name']; ?></h4>
                        <?php echo $requestedCustomer['university']; ?><br>
                        <?php echo $requestedCustomer['address']; ?><br>
                        <?php echo $requestedCustomer['city'] . ', ' . $requestedCustomer['country']; ?>

                    </div>
                  </div>  <!-- / mdl-cell + mdl-card -->

                  <!-- mdl-cell + mdl-card -->
                  <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card  mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Order Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">


                           <?php

                           $orders = readOrders( $_GET['customer'], 'data/orders.txt' );
                           if ( is_null($orders) ) {
                                echo 'No orders for ' . $requestedCustomer['name'];
                           } else {
                             foreach ($orders as $order) {
                               $id = $order["id"];
                               $customer = $order["customer"];
                               $isbn = $order["isbn"];
                               $title = $order["title"];
                               $category = $order["category"];
                               $orderList[$id] = new Order($id,$customer,$isbn,$title,$category);
                             }
                            ?>

                               <table class="mdl-data-table  mdl-shadow--2dp">
                              <thead>
                                <tr>
                                  <th class="mdl-data-table__cell--non-numeric">Cover</th>
                                  <th class="mdl-data-table__cell--non-numeric">ISBN</th>
                                  <th class="mdl-data-table__cell--non-numeric">Title</th>
                                </tr>
                              </thead>
                              <tbody>

                                 <?php foreach ($orderList as $ord) {
                                   //orders from one customer?
                                    echo '<tr>';
                                    echo '<td><img src="images/tinysquare/' . $ord->ISBN . '.jpg"></td>';
                                    echo '<td>' . $ord->ISBN . '</td>';
                                    echo '<td class="mdl-data-table__cell--non-numeric"><a href="chapter13-project03.php?isbn=' . $ord->ISBN . '">' . $ord->title . '</td>';
                                    echo '</tr>    ';

                                 } ?>

                              </tbody>
                            </table>
                         <?php  } ?>

                        </div>
                      </div>  <!-- / mdl-cell + mdl-card -->


                     <?php
                        }
                     } ?>


</div>


            </div>  <!-- / mdl-grid -->

        </section>
    </main>
</div>    <!-- / mdl-layout -->

</body>
</html>
