<?php
session_start();
if (!isset($_SESSION["login"])){
  header ("Location: login.php");
  exit;
}
require 'functions.php';
// Summary
    $item = query("SELECT COUNT('id') a FROM location");
// Chart Order, Stocked, Scrapped and Cost
    $dataloc = mysqli_query($conn,"SELECT DISTINCT name FROM location");
    while($row = mysqli_fetch_array($dataloc)){
        $location[] = $row['name'];
        $loc = count($location);
        $query = mysqli_query($conn,"SELECT SUM(productionCost) AS 'Total Costs', SUM(OrderQty) AS 'Total Order',
                                            SUM(StockedQty) AS 'Total Stocked', SUM(scrappedQty) AS 'Total Scrapped'
                                        FROM production_fact s
                                        JOIN location p ON (s.location_key=p.id)
                                        where name='".$row['name']."'");
        $row = $query->fetch_array();
        $dataOpC[] = $row['Total Order'];
        $dataIpC[] = $row['Total Costs'];
        $dataTpC[] = $row['Total Stocked'];
        $dataCpC[] = $row['Total Scrapped'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Production Charts</title>
    <!-- Custom fonts for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="drilldown.css">
    <!-- Script -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
    <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                  <i class="bi bi-database-fill"></i>
                </div>
                <div class="sidebar-brand-text mx-3 pt-2">DWA<sup>2023</sup></div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                  <i class="bi bi-speedometer"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <!-- Nav Item - Charts Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCharts1"
                    aria-expanded="true" aria-controls="collapseCharts1">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Sales Charts</span>
                </a>
                <div id="collapseCharts1" class="collapse" aria-labelledby="headingCharts"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Charts :</h6>
                        <a class="collapse-item" href="CproductA.php">Product</a>
                        <a class="collapse-item" href="Cregion.php">Region</a>
                        <a class="collapse-item" href="Ccustomer.php">Customer</a>
                        <a class="collapse-item" href="Cdelivery.php">Delivery</a>
                        <a class="collapse-item" href="Corderfinance.php">Ordering and Financial</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCharts2"
                    aria-expanded="true" aria-controls="collapseCharts2">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Production Charts</span>
                </a>
                <div id="collapseCharts2" class="collapse" aria-labelledby="headingCharts"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Charts :</h6>
                        <a class="collapse-item" href="CproductB.php">Product</a>
                        <a class="collapse-item" href="Clocation.php">Location</a>
                        <a class="collapse-item" href="Cproduction.php">Production</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
    <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
            <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800 pt-4 ps-2">DATA WAREHOUSE ADVENTUREWORKS 2023</h1>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

            <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Content Row -->
                    <h1 class="h3 mb-2 text-gray-800">Production - Location</h1>
                    <div class="row">
                    <!-- Total Locations -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Locations</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $item[0]["a"]?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-house-gear text-gray-300" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Charts</h1>
                    <!-- Content Row -->
                    <div class="row ">
                    <!-- Bar Chart DrillDown -->
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Order Quantities Data</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="d-flex justify-content-center">
                                    <figure class="highcharts-figure">
                                        <div id="OpC"></div>
                                        <p class="highcharts-description">
                                            Data by Location
                                        </p>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Stocked Quantities Data</h6>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <figure class="highcharts-figure">
                                        <div id="TpC"></div>
                                        <p class="highcharts-description">
                                            Data by Location
                                        </p>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Scrapped Quantities Data</h6>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <figure class="highcharts-figure">
                                        <div id="CpC"></div>
                                        <p class="highcharts-description">
                                            Data by Location
                                        </p>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Production Costs Data</h6>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <figure class="highcharts-figure">
                                        <div id="IpC"></div>
                                        <p class="highcharts-description">
                                            Data by Location
                                        </p>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sephele 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

<!-- Script Default -->
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>
<!-- Script Chart Order-->
    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('OpC', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Data by Location'
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:,.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.0f}</b> of total<br/>'
            },

            series: [
                {
                    name: "Location",
                    colorByPoint: true,
                    data: 
                    [ 
                    <?php for ($i=0; $i < $loc; $i++) {
                        if ($dataOpC[$i]!=null) {
                            echo "{
                                name: \"$location[$i]\",
                            y: $dataOpC[$i],
                            drilldown: null
                            }";
                            if ($i!=($loc-1)){
                                echo ",";
                            }
                        }
                    }  
                    ?>
                    ]
                }
            ]
        });
    </script>
<!-- Script Chart Stocked-->
    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('TpC', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Data by Location'
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:,.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.0f}</b> of total<br/>'
            },

            series: [
                {
                    name: "Location",
                    colorByPoint: true,
                    data: 
                    [
                        <?php for ($i=0; $i < $loc; $i++) {
                        if ($dataTpC[$i]!=null) {
                            echo "{
                                name: \"$location[$i]\",
                            y: $dataTpC[$i],
                            drilldown: null
                            }";
                            if ($i!=($loc-1)){
                                echo ",";
                            }
                        }
                    }  
                    ?>
                    ]
                }
            ]
        });
    </script>
<!-- Script Chart Scrapped-->
    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('CpC', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Data by Location'
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:,.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.0f}</b> of total<br/>'
            },

            series: [
                {
                    name: "Location",
                    colorByPoint: true,
                    data: 
                    [
                        <?php for ($i=0; $i < $loc; $i++) {
                        if ($dataCpC[$i]!=null) {
                            echo "{
                                name: \"$location[$i]\",
                            y: $dataCpC[$i],
                            drilldown: null
                            }";
                            if ($i!=($loc-1)){
                                echo ",";
                            }
                        }
                    }  
                    ?>
                    ]
                }
            ]
        });
    </script>
<!-- Script Chart Costs-->
    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('IpC', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Costs by Location'
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: ${point.y:,.2f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>${point.y:,.2f}</b> of total<br/>'
            },

            series: [
                {
                    name: "Location",
                    colorByPoint: true,
                    data: 
                    [
                        <?php for ($i=0; $i < $loc; $i++) {
                        if ($dataIpC[$i]!=null) {
                            echo "{
                                name: \"$location[$i]\",
                            y: $dataIpC[$i],
                            drilldown: null
                            }";
                            if ($i!=($loc-1)){
                                echo ",";
                            }
                        }
                    }  
                    ?>
                    ]
                }
            ]
        });
    </script>
</body>

</html>