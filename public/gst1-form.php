<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> -->
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

                <main class="page-content">
                    <section class="section-98 section-md-110 section-bottom-66">
                        <div class="container">
                            <div class="offset-md-top-66">
                                <ul class="nav nav-mytabs d-flex" id="myTab" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">Sale</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="history-tab" data-toggle="tab" href="#register" role="tab" aria-controls="history" aria-selected="false">Sale Return</a>
                                    </li>
                                </ul>
                                <div class="tab-content mytab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row justify-content-sm-center section-34">
                                            <div class="col-sm-11 col-md-11 col-lg-11">
                                                <p>Invoice Details</p>
                                                <table>
                                                    <tr>
                                                        <th>GSTIN/UIN </th>
                                                        <th>Party Name </th>
                                                        <th>Invoice No. </th>
                                                        <th>Date </th>
                                                        <th>Value </th>
                                                        <th>Tax Rate </th>
                                                        <th>Cess Rate </th>
                                                        <th>Taxable Value  </th>
                                                        <th>Central Tax  </th>
                                                        <th>State/UT Tax  </th>
                                                        <th>Cess  </th>
                                                        <th>Place Of Supply(Name of State) </th>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row justify-content-sm-center section-34" id="register">
                                            <div class="col-sm-11 col-md-11 col-lg-11">
                                                <p>Cr. Note Details</p>
                                                <table>
                                                    <tr>
                                                        <th>GSTIN/UIN </th>
                                                        <th>Party Name </th>
                                                        <th>Invoice No. </th>
                                                        <th>Invoice Date </th>
                                                        <th>Note No. </th>
                                                        <th>Note Date </th>
                                                        <th>Value </th>
                                                        <th>Tax Rate </th>
                                                        <th>Cess Rate </th>
                                                        <th>Taxable Value  </th>
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
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>     
    </div>
</body>
</html>