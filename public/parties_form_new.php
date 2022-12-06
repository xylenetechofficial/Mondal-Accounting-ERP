<?php

include_once('includes/functions.php');

//get all the files in the directory

$Controller = new functions;

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> -->
    <title>Parties Form</title>
</head>

<body>
    <div class="parties-form">
        <div class="upper-nav d-flex align-items-center justify-content-between">
            <div class="input-field">
                <!-- <input type="text" name="" placeholder="Enter Business Name" id=""><input type="submit" value="Save"> -->
                <h1>Enter Business Name</h1>
            </div>
            <div class="button">
                <a class="sale" href=""><i class="fa fa-plus-circle"></i>Add Sale</a>
                <a class="purchase" href=""><i class="fa fa-plus-circle"></i>Add Purchase</a>
                <a class="more" href=""><i class="fa fa-plus-circle"></i>Add More</a>
                <i class="fa fa-gear"></i>
            </div>
        </div>
        <div class="small-nav">
            <h3>Name</h3>
        </div>
        <div class="party-container">
            <div class="row imports">
                <div class="import-parties">
                    <div class="phonebook">
                        <!-- <img src="../images/phonebook.png" alt=""> -->
                    </div>
                    <div class="label">
                        <h4> Import Parties</h4>
                        <p>Use contacts from your <br> Phone or Gmail to create <br> parties.</p>
                    </div>
                    <div class="arrow">
                        <a href=""><span>&#8250;</span></a>
                    </div>
                </div>

                <div class="add-search">
                    <div class="search">
                        <a href=""><i class="fa fa-search"></i></a>
                    </div>
                    <div class="add">
                        <a href="./add_party.php"><i class="fa fa-plus-circle"></i> Add Party</a>
                    </div>
                </div>
                <div class="party-amount">
                    <div class="party">
                        <a href=""><span>&#8593;</span> Party</a>
                        <a href=""><i class="fa fa-filter"></i></a>
                    </div>
                    <div class="amount">
                        <p>AMOUNT</p>
                    </div>
                </div>
                <?php $party_list = $Controller->getAllPartyData('party');
                // print_r($party_list);
                foreach ($party_list as $party) {
                ?>
                    <div class="profile-info">
                        <div class="name">
                        <a id="<?php echo $party['party_id']; ?>"><p><?php echo $party['name']; ?></p></a>
                        </div>
                        <div class="price">
                            <p> <span>&#8377;</span> 00.00</p>
                            <a href=""><span>&#8285;</span></a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            
            <div class="container d-block">
                <div class="row party-profile">
                    <div class="name">
                        <h4>ARUNAVA</h4>
                    </div>
                    <div class="phone-address">
                        <div class="phone">
                            <p>Phone: 8584970202</p>
                        </div>
                        <div class="address">
                            <p>Address: </p>
                        </div>
                    </div>
                    <div class="email-gstin">
                        <div class="email">
                            <p>Email: </p>
                        </div>
                        <div class="gstin">
                            <p>Gstin: </p>
                        </div>
                    </div>
                    <p>No Credit Limit Set</p>

                </div>
                <div class="row party-transactions">
                    <div class="transaction-search">
                        <div class="transaction">
                            <h4>transactions</h4>
                        </div>
                        <input type="search" name="" placeholder="Search" id="">

                    </div>
                    <table>
                        <tr>
                            <th>Type <i class="fa fa-filter"></i></th>
                            <th>Number <i class="fa fa-filter"></i></th>
                            <th><span>&#8593;</span> Date <i class="fa fa-filter"></i></th>
                            <th>Total <i class="fa fa-filter"></i></th>
                            <th>Balance <i class="fa fa-filter"></i></th>
                        </tr>
                        <tr>
                            <td>Sale</td>
                            <td>1</td>
                            <td>26/11/2022</td>
                            <td><span>&#8377;</span>0.00</td>
                            <td><span>&#8377;</span>0.00 <a href=""><span>&#8285;</span></a></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</body>

</html>