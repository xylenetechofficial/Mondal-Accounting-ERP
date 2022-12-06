<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Sale Form</title>
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
        <div class="container">
            <div class="row party-transactions">
                <div class="top-area">
                    <div class="month">
                        <h2><a href="">This Month <span>&#94;</span> </a></h2>
                    </div>
                    <div class="between">
                        <label for="" class="between-button">Between</label>
                        <input type="date" name="" id="">
                        <label for="" class="to-button">To</label>
                        <input type="date" name="" id="">
                    </div>
                    <div class="firms">
                        <div class="dropdown">
                            <button class="form-group btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ADD FIRMS
                            </button>
                            <div class="dropdown-menu d-block" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btn" data-toggle="modal" data-target="#exampleModal" href="#">Bank to Cash Transfer</button>
                                <button class="dropdown-item btn" data-toggle="modal" data-target="#exampleModal1" href="#">Cash to Bank Transfer</button>
                                <button class="dropdown-item btn" data-toggle="modal" data-target="#exampleModal2" href="#">Bank to Bank Transfer</button>
                                <button class="dropdown-item btn" data-toggle="modal" data-target="#exampleModal3" href="#">Adjust Bank Balance</button>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="graph">
                            <a href=""><i class="fa fa-bar-chart-o"></i></a>&nbsp;&nbsp;
                            <p>Graph</p>
                        </div>
                        <div class="excel">
                            <a href=""><i class="fa fa-file-excel-o"></i></a>&nbsp;&nbsp;
                            <p>Excel Report</p>
                        </div>
                        <div class="print">
                            <a href=""><i class="fa fa-print"></i></a>
                            <p>Print</p>
                        </div>
                    </div>

                </div>
                <div class="mid-area">
                    <div class="paid">
                        <h4>Paid</h4>
                        <p><span>&#8377;</span>&nbsp;0.00</p>
                    </div>
                    <div class="plus"><i class="fa fa-plus"></i></div>
                    <div class="unpaid">
                        <h4>Unpaid</h4>
                        <p><span>&#8377;</span>&nbsp;0.00</p>
                    </div>
                    <div class="equal"><span>&equals;</span></div>
                    <div class="total">
                        <h4>Total</h4>
                        <p><span>&#8377;</span>&nbsp;0.00</p>
                    </div>
                </div>
                <h4>TRANSACTIONS</h4>
                <div class="transaction-search">
                    <div class="transaction">
                        <input type="search" name="" placeholder="Search" id="">   
                    </div>
                    <button class="btn btn-primary"> <i class="fa fa-plus-circle"></i> Add Sale</button>
                </div>
                <table>
                    <tr>
                        <th>Date <i class="fa fa-filter"></i></th>
                        <th>Invoice <i class="fa fa-filter"></i></th>
                        <th>Party Name <i class="fa fa-filter"></i></th>
                        <th>Transaction <i class="fa fa-filter"></i></th>
                        <th>Payment <i class="fa fa-filter"></i></th>
                        <th>Amount <i class="fa fa-filter"></i></th>
                        <th>Balance <i class="fa fa-filter"></i></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>26/11/2022</td>
                        <td>1</td>
                        <td>Arunava</td>
                        <td>Sale</td>
                        <td>Cash</td>
                        <td><span>&#8377;</span>&nbsp;0</td>
                        <td><span>&#8377;</span>&nbsp;0</td>
                        <td><a href=""><i class="fa fa-print"></i></a> &nbsp;&nbsp;<a href=""><i class="fa fa-solid fa-share"></i></a> &nbsp;&nbsp; <a href=""><span>&#8285;</span></a></td>
                    </tr>
                </table>               
            </div>
        </div>
    </div>
</body>
</html>