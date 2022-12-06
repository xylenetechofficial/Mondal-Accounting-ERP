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
                <h4 class="mt-3 mb-2">GSTR3B REPORT</h4>
                <div class="outward-suppliers">
                    <h3>1. Details of outward suppliers and inward supplies liable to reverse charge</h3>
                    <table>
                        <tr>
                            <th>Nature of Supplies</th>
                            <th>Total Taxable Value</th>
                            <th>Integrated Tax</th>
                            <th>Central Tax</th>
                            <th>State/UT Tax</th>
                            <th>Cess</th>
                        </tr>
                        <tr>
                            <td>Outward taxable supplies (other than zero rated, nil rated and exempted)</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Outward taxable supplies(zero Rated)</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            
                        </tr>
                        <tr>
                            <td>Other outward supplies (Nil rated, exempted)</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>

                        </tr>
                        <tr>
                            <td>Inward supplies (liable to reverse charge)</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>

                        </tr>
                        <tr>
                            <td>Non-GST outward supplies</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>

                        </tr>
                        
                    </table>


                </div>
                <div class="inter-state">
                    <h3>2. Details of inter-state supplies made to unregistered persons, composition dealer and UIN holders</h3>
                    <table>
                        <tr>
                            <th>Place of Supply(State/UT)</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </table>

                </div>
                <div class="tax-credit">
                    <h3>3. Details of eligible Input Tax Credit</h3>
                    <table>
                        <tr>
                            <th>Details</th>
                            <th>Integrated Tax</th>
                            <th>Central Tax</th>
                            <th>State/UT Tax</th>
                            <th>Cess</th>
                        </tr>
                        <tr>
                            <td>(1) Import of goods</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>(2) Import of services</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>(3) Inward supplies liable to reverse charge (other than 1 & 2 above)</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>(4) Inward supplies from ISD</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>(5) All other ITC</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <!-- <h4>(D) Ineleigible ITC</h4> -->
                        <tr>
                            <td>(1) As per section 17(5)</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>(2) Others</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </table>

                </div>
                <div class="non-gst">
                    <h3>4. Details of exempt, nil-rated and non-GST inward supplies</h3>
                    <table>
                        <tr>
                            <th>Nature of Supplies</th>
                            <th>Inter-State Supplies</th>
                            <th>Intra-State Supplies</th>
                        </tr>
                        <tr>
                            <td>From a supplier under composition scheme, Exempt and Nil rated Supply</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Non GST Supply</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
        