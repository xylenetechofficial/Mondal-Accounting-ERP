<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
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

                        <input type="checkbox" name="" id="">
                        <label for="">Show Zero amount Transactions</label>
                    </div>
                    <div class="right">
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
                <p class="cash-hand">Opening Cash-in Hand: <span>&#8377;</span>&nbsp; 0.00 </p>
                    <div class="transaction">
                        <input type="search" name="" placeholder="Search" id="">   
                    </div>
                <table>
                    <tr>
                        <th>Date <i class="fa fa-filter"></i></th>
                        <th>Ref No. <i class="fa fa-filter"></i></th>
                        <th>Name <i class="fa fa-filter"></i></th>
                        <th>Category <i class="fa fa-filter"></i></th>
                        <th>Type <i class="fa fa-filter"></i></th>
                        <th>Cash In <i class="fa fa-filter"></i></th>
                        <th>Cash... <i class="fa fa-filter"></i></th>
                        <th>Running... <i class="fa fa-filter"></i> </th>
                        <th>Print... <i class="fa fa-filter"></i> </th>
                    </tr>
                    <tr class="empty-field">
                        <!-- <td>26/11/2022</td> -->
                        <!-- <td>1</td> -->
                        <!-- <td>Arunava</td> -->
                        <!-- <td>Sale</td> -->
                        <!-- <td>Cash</td> -->
                        <!-- <td><span>&#8377;</span>&nbsp;0</td> -->
                        <!-- <td><span>&#8377;</span>&nbsp;0</td> -->
                        <!-- <td><a href=""><i class="fa fa-print"></i></a> &nbsp;&nbsp;<a href=""><i class="fa fa-solid fa-share"></i></a> &nbsp;&nbsp; <a href=""><span>&#8285;</span></a></td> -->
                    </tr>
                </table>               
                <div class="empty">
                    <p class="text-center">No transaction to Show</p>
                    <div class="cash">
                        <div class="total-in">
                            <p>Total Cash-in: <span>&#8377;</span>&nbsp; 0.00</p>
                        </div>
                        <div class="total-out">
                            <p>Total Cash-Out: <span>&#8377;</span>&nbsp; 0.00</p>
                        </div>
                        <div class="total-closing">
                            <p>Closing Cash-in Hand: <span>&#8377;</span>&nbsp; 0.00</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        


    </div>
</body>
</html>