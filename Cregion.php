<?php
session_start();
if (!isset($_SESSION["login"])){
  header ("Location: login.php");
  exit;
}
require 'functions.php';
// Summary and Top 10
    $item = query("SELECT COUNT('id') a, COUNT(DISTINCT city) b, COUNT(DISTINCT province) c, COUNT(DISTINCT country) d FROM address");
    $top10 = query("SELECT SUM(OrderQty) AS 'OrderQty', city, province FROM sales_fact f JOIN address p ON (f.address_key=p.id) GROUP BY city
                    ORDER BY OrderQty DESC LIMIT 8");
// Chart City, Province and Country
    $datacat1 = mysqli_query($conn,"SELECT DISTINCT country FROM address");
    $datasub1 = mysqli_query($conn,"SELECT DISTINCT province FROM address");
    while($row = mysqli_fetch_array($datacat1)){
        $category1[] = $row['country'];
        $cat1 = count($category1);
        $query = mysqli_query($conn,"SELECT COUNT(DISTINCT province) AS 'province'
                                        FROM address WHERE country='".$row['country']."'");
        $row = $query->fetch_array();
        $dataSpC[] = $row['province'];
    }
    while($row = mysqli_fetch_array($datasub1)){
        $subcategory1[] = $row['province'];
        $sub1 = count($subcategory1);
        $query = mysqli_query($conn,"SELECT COUNT(DISTINCT city) AS 'city', country
                                        FROM address WHERE province=\"".$row['province']."\"");
        $row = $query->fetch_array();
        $dataPpS[]= $row['city'];
        $datadcat1[]=$row['country'];
    }
// Chart Order and Income
    $datacat2 = mysqli_query($conn,"SELECT DISTINCT country FROM address");
    $datasub2 = mysqli_query($conn,"SELECT DISTINCT province FROM address");
    while($row = mysqli_fetch_array($datacat2)){
        $category2[] = $row['country'];
        $cat2 = count($category2);
        $query = mysqli_query($conn,"SELECT SUM(LineTotal) AS 'Total Incomes', SUM(OrderQty) AS 'Total Order'
                                        FROM sales_fact s
                                        JOIN address p ON (s.address_key=p.id)
                                        where country='".$row['country']."'");
        $row = $query->fetch_array();
        $dataOpC[] = $row['Total Order'];
        $dataIpC[] = $row['Total Incomes'];
    }
    while($row = mysqli_fetch_array($datasub2)){
        $subcategory2[] = $row['province'];
        $sub2 = count($subcategory2);
        $query = mysqli_query($conn,"SELECT SUM(LineTotal) AS 'Total Incomes', SUM(OrderQty) AS 'Total Order', country
                                        FROM sales_fact s
                                        JOIN address p ON (s.address_key=p.id) 
                                        WHERE province=\"".$row['province']."\"");
        $row = $query->fetch_array();
        $dataOpS[]= $row['Total Order'];
        $dataIpS[]= $row['Total Incomes'];
        $datadcat2[]=$row['country'];
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
    <title>Sales Charts</title>
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
                    <h1 class="h3 mb-2 text-gray-800">Sales - Region</h1>
                    <div class="row">
                    <!-- Total Addresses -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Addresses</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($item[0]["a"], 0, ',', ' ')?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-house text-gray-300" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- Total Cities -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Cities</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $item[0]["b"]?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-building text-gray-300" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- Total Provincies -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Provincies</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $item[0]["c"]?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-geo-alt text-gray-300" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- Total Countries -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Countries</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $item[0]["d"]?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-flag text-gray-300" style="font-size: 3rem;"></i>
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
                    <!-- Donut Chart DrillDown -->
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">City, Province and Country</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="d-flex justify-content-center">
                                    <figure class="highcharts-figure">
                                        <div id="SpC"></div>
                                        <p class="highcharts-description">
                                            Data Provinces by Countries => Cities by Provinces.
                                        </p>
                                    </figure>
                                </div>
                            </div>
                        </div>
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
                                            Data by Countries => Data by provinces.
                                        </p>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Incomes Data</h6>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <figure class="highcharts-figure">
                                        <div id="IpC"></div>
                                        <p class="highcharts-description">
                                            Data by Countries => Data by provinces.
                                        </p>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    <!-- Top 10 -->
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top 8 cities with the most orders</h6>
                                </div>
                                <div class="d-flex justify-content-center p-2 pb-2">
                                    <table class="table align-middle">
                                        <tr>
                                            <th>No</th>
                                            <th>City</th>
                                            <th>Province</th>
                                            <th>Total Orders</th>
                                        </tr>
                                    <?php $i=1; foreach ($top10 as $row) : ?>
                                    <tr>
                                        <td><?= $i?></td>
                                        <td><?= $row["city"]?></td>
                                        <td><?= $row["province"]?></td>
                                        <td><?= number_format($row["OrderQty"], 0, ',', ' ')?></td>
                                    </tr>
                                    <?php $i++; endforeach ?>
                                    </table>
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

<!-- Script Chart City, Province and Country -->
    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('SpC', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Province Total by Countries'
            },
            subtitle: {
                text: 'Click the slices to view City Total by Provinces.'
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
                        format: '{point.name}: {point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },

            series: [
                {
                    name: "Province",
                    colorByPoint: true,
                    data: 
                    [ 
                    <?php for ($i=0; $i < $cat1; $i++) { 
                        echo "{ name: \"$category1[$i]\",
                            y: $dataSpC[$i],
                            drilldown: \"$category1[$i]\"
                        }";
                        if ($i!=($cat1-1)){
                            echo ",";
                        }
                    }  
                    ?>
                    ]
                }
            ],
            drilldown: {
                series: [
                    <?php for ($i=0; $i < $cat1; $i++) { 
                        echo "{ name: \"$category1[$i]\",
                        id: \"$category1[$i]\",
                            data: [
                                ";
                                for ($j=0; $j < $sub1; $j++) { 
                                    if ($datadcat1[$j]==$category1[$i]) {
                                        echo "[
                                            \"$subcategory1[$j]\",
                                            $dataPpS[$j]
                                        ]";
                                        if ($j!=($sub1-1)){
                                            echo ",";
                                        }
                                    } 
                                }
                        echo "]}";
                        if ($i!=($cat1-1)){
                            echo ",";
                        }
                    }
                    ?>
                ]
            }
        });
    </script>

<!-- Script Chart Order-->
    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('OpC', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Data by Countries'
            },
            subtitle: {
                text: 'Click the slices to view Data by Provinces.'
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
                    name: "Province",
                    colorByPoint: true,
                    data: 
                    [ 
                    <?php for ($i=0; $i < $cat2; $i++) { 
                        echo "{ name: \"$category2[$i]\",
                            y: "; if ($dataOpC[$i]==null) {
                                echo "0,
                                drilldown: null
                            }";
                            } else {echo " $dataOpC[$i],
                                drilldown: \"$category2[$i]\"
                            }";}
                        if ($i!=($cat2-1)){
                            echo ",";
                        }
                    }  
                    ?>
                    ]
                }
            ],
            drilldown: {
                series: [
                    <?php for ($i=0; $i < $cat2; $i++) { 
                        echo "{ name: \"$category2[$i]\",
                        id: \"$category2[$i]\",
                            data: [
                                ";
                                for ($j=0; $j < $sub2; $j++) { 
                                    if ($datadcat2[$j]==$category2[$i]) {
                                        echo "[
                                            \"$subcategory2[$j]\","; 
                                            if ($dataOpS[$j]==null) {
                                                echo 0;
                                            } else {echo $dataOpS[$j];}
                                        echo "
                                        ]";
                                        if ($j!=($sub2-1)){
                                            echo ",";
                                        }
                                    } 
                                }
                        echo "]}";
                        if ($i!=($cat2-1)){
                            echo ",";
                        }
                    }
                    ?>
                ]
            }
        });
    </script>
<!-- Script Chart Incomes-->
    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('IpC', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Incomes by Countries'
            },
            subtitle: {
                text: 'Click the slices to view Data by Provinces.'
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
                    name: "Province",
                    colorByPoint: true,
                    data: 
                    [ 
                    <?php for ($i=0; $i < $cat2; $i++) { 
                        echo "{ name: \"$category2[$i]\",
                            y: "; if ($dataIpC[$i]==null) {
                                echo "0,
                                drilldown: null
                            }";
                            } else {echo " $dataIpC[$i],
                                drilldown: \"$category2[$i]\"
                            }";}
                        if ($i!=($cat2-1)){
                            echo ",";
                        }
                    }  
                    ?>
                    ]
                }
            ],
            drilldown: {
                series: [
                    <?php for ($i=0; $i < $cat2; $i++) { 
                        echo "{ name: \"$category2[$i]\",
                        id: \"$category2[$i]\",
                            data: [
                                ";
                                for ($j=0; $j < $sub2; $j++) { 
                                    if ($datadcat2[$j]==$category2[$i]) {
                                        echo "[
                                            \"$subcategory2[$j]\","; 
                                            if ($dataOpS[$j]==null) {
                                                echo 0;
                                            } else {echo $dataOpS[$j];}
                                        echo"]";
                                        if ($j!=($sub2-1)){
                                            echo ",";
                                        }
                                    } 
                                }
                        echo "]}";
                        if ($i!=($cat2-1)){
                            echo ",";
                        }
                    }
                    ?>
                ]
            }
        });
    </script>
</body>

</html>