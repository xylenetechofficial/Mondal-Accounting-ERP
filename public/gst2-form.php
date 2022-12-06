<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>GSTR 1 Form</title>
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
                <div class="top-area mini-nav">
                    <div class="between">
                        <div class="from">
                            <label for="" class="between-button">From Month/Year</label>
                            <input type="month" name="" id="">
                            
                        </div>
                        <div class="to">
                            <label for="" class="to-button">To Month/Year</label>
                            <input type="month" name="" id="">
                        </div>
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
                <input type="checkbox" name="" id="">
                <label for="">Consider non-tax as exempted</label>
                <h4 class="mt-3 mb-2">GSTR2 REPORT</h4>
                <table>
                    <h5>Bill Details</h5>
                    <tr>
                        <th>GSTIN/UIN </th>
                        <th>Party Name </th>
                        <th>No. </th>
                        <th>Date </th>
                        <th>Value </th>
                        <th>Rate </th>
                        <th>Cess Rate </th>
                        <th>Taxable Value  </th>
                        <th>Reverse Charge  </th>

                        <th>Integrated Tax  </th>
                        <th>Central Tax  </th>
                        <th>State/UT Tax  </th>
                        <th>Cess  </th>
                        <th>Place Of Supply(Name of State) </th>
                    </tr>

                </table>
            </div>
        </div>     
    </div>
</body>
</html>