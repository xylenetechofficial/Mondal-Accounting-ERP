<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/js/bootstrap.min.js">
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
            <h3>Bank</h3>
        </div>
        <div class="party-container">
            <div class="row imports">
                <div class="add-search">
                    <div class="search">
                        <a href=""><i class="fa fa-search"></i></a>
                    </div>
                    <div class="add">
                        <!-- <a href="./public/add_bank_new.php"><i class="fa fa-plus-circle"></i> Add Bank</a> -->

                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus-circle"></i> Add Bank</button>

                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Add Bank Account</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="content d-flex align-items-center justify-content-between">     
                                            <div class="form-group col-12 col-md-4 col-sm">
                                                <!-- <label for="exampleInputEmail1">Account Display Name</label> -->
                                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Account Display Name">
                                            </div>
                                            <div class="form-group col-12 col-md-4 col-sm">
                                                <!-- <label for="exampleInputPassword1">Password</label> -->
                                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                            </div>
                                            <div class="form-group col-12 col-md-4 col-sm">
                                                <input type="date" class="form-control" id="exampleDate1">
                                                <!-- <label class="form-check-label" for="exampleCheck1">Check me out</label> -->
                                            </div>
                                        </div>
                                        <div class="check-content mt-5 mb-5">
                                            <div class="form-check">
                                                <input type="checkbox" name="form-input-check" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Print UPI QR Code on Invoices</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="form-input-check" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Print Bank Details on Invoices</label>
                                            </div>
                                        </div>
                                        <div class="bank-link">
                                            <div class="form-check">
                                                <input type="checkbox" name="form-input-check" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Link Bank Account Online</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary text-right">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="party-amount">
                    <div class="party">
                        <a href=""><span>&#8593;</span> ACCOUNT NAME</a>
                    </div>
                    <div class="amount">
                        <p>AMOUNT</p>
                    </div>
                </div>
                <div class="profile-info">
                    <div class="name">
                        <p>Arunava Chowdhary</p>
                    </div>
                    <div class="price">
                        <p><span>&#8377;</span>200.00</p>
                        <a href=""><span>&#8285;</span></a>
                    </div>
                </div>
            </div>
            <div class="container d-block">
                <div class="row party-profile">
                    <div class="phone-address">
                        <div class="phone">
                            <h4>Bank Name:</h4>
                            <h4>Account Number:</h4>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Deposit/Withdraw
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btn" data-toggle="modal" data-target="#exampleModal" href="#">Bank to Cash Transfer</button>
                                <button class="dropdown-item btn" data-toggle="modal" data-target="#exampleModal1" href="#">Cash to Bank Transfer</button>
                                <button class="dropdown-item btn" data-toggle="modal" data-target="#exampleModal2" href="#">Bank to Bank Transfer</button>
                                <button class="dropdown-item btn" data-toggle="modal" data-target="#exampleModal3" href="#">Adjust Bank Balance</button>
                            </div>

                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">Bank to Cash Transfer</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="POST" encytye="multipart/form-data">
                                                <div class="content d-flex align-items-center justify-content-between">     
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleInputEmail1">From</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Bank" readonly>
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleInputPassword1">To</label>
                                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="To">
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleCheck1">Amount</label>
                                                        <input type="text" class="form-control" id="exampleDate1" placeholder="Amount">
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleCheck1">Date</label>
                                                        <input type="date" class="form-control" id="exampleDate1">
                                                    </div>
                                                    <div class="form-group col-12 col-md-12 col-sm">
                                                        <label for="exampleCheck1">Add Description</label>
                                                        <input type="text" class="form-control" id="exampleDate1" placeholder="Add Description">
                                                    </div>
                                                </div>                                                
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">Cash to Bank Transfer</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="POST" encytye="multipart/form-data">
                                            <div class="content d-flex align-items-center justify-content-between">     
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleInputEmail1">From</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Cash" readonly>
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleInputPassword1">To</label>
                                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="To">
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleCheck1">Amount</label>
                                                        <input type="text" class="form-control" id="exampleDate1" placeholder="Amount">
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleCheck1">Date</label>
                                                        <input type="date" class="form-control" id="exampleDate1">
                                                    </div>
                                                    <div class="form-group col-12 col-md-12 col-sm">
                                                        <label for="exampleCheck1">Add Description</label>
                                                        <input type="text" class="form-control" id="exampleDate1" placeholder="Add Description">
                                                    </div>
                                                </div>                                                
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">Bank to Bank Transfer</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="POST" encytye="multipart/form-data">
                                            <div class="content d-flex align-items-center justify-content-between">     
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleInputEmail1">From</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Bank" readonly>
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleInputPassword1">To</label>
                                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="To">
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleCheck1">Amount</label>
                                                        <input type="text" class="form-control" id="exampleDate1" placeholder="Amount">
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleCheck1">Date</label>
                                                        <input type="date" class="form-control" id="exampleDate1">
                                                    </div>
                                                    <div class="form-group col-12 col-md-12 col-sm">
                                                        <label for="exampleCheck1">Add Description</label>
                                                        <input type="text" class="form-control" id="exampleDate1" placeholder="Add Description">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">Adjust Bank Balance</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="POST" encytye="multipart/form-data">
                                            <div class="content d-flex align-items-center justify-content-between">     
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleInputEmail1">From</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Bank" readonly>
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleInputPassword1">To</label>
                                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="To">
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleCheck1">Amount</label>
                                                        <input type="text" class="form-control" id="exampleDate1" placeholder="Amount">
                                                    </div>
                                                    <div class="form-group col-12 col-md-6 col-sm">
                                                        <label for="exampleCheck1">Date</label>
                                                        <input type="date" class="form-control" id="exampleDate1">
                                                    </div>
                                                    <div class="form-group col-12 col-md-12 col-sm">
                                                        <label for="exampleCheck1">Add Description</label>
                                                        <input type="text" class="form-control" id="exampleDate1" placeholder="Add Description">
                                                    </div>
                                                </div>                                                
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="name">
                        <h4>IFSC Code:</h4>
                    </div>
                    <div class="email-gstin">
                        <div class="email">
                            <h4>UPI ID: </h4>
                        </div>
                        <div class="gstin">
                            <p>Balance on Vyapar: <span>&#8377;</span> 200.00</p>
                        </div>
                    </div>
                
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
                            <th>Name<i class="fa fa-filter"></i></th>
                            <th><span>&#8593;</span> Date <i class="fa fa-filter"></i></th>
                            <th>Amount <i class="fa fa-filter"></i></th>
                        </tr>
                        <tr>
                            <td>Opening Balance</td>
                            <td>Opening Balance</td>
                            <td>26/11/2022</td>
                            <td><span>&#8377;</span>200.00 <a href=""><span>&#8285;</span></a></td>
                        </tr>
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</body>
</html>