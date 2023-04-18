<?php

session_start();

if (empty($_SESSION['college'])) {
  header("Location: ..college_login.php");
  exit();
}

require_once("../db.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Placement Portal</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/AdminLTE.min.css">
  <link rel="stylesheet" href="../css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="../css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>'
  <![endif]-->
  <script src="https://code.highcharts.com/highcharts.js"></script>
 <script src="https://code.highcharts.com/modules/exporting.js"></script>
 <script src="https://code.highcharts.com/modules/export-data.js"></script>
 <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <?php

    include 'header.php';
    $college_name = $_SESSION['name'];

    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px;">

      <section id="candidates" class="content-header">
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Welcome <b><?php echo $college_name?></b></h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="create_account.php"><i class="fa fa-briefcase"></i> Add a Student</a></li>
                    <li><a href="manage_acount.php"><i class="fa fa-address-card-o"></i>Edit a Students Profile</a></li>
                    <li><a href="../logout.php"><i class="fa fa-arrow-circle-o-right"></i> Logout</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-9 bg-white padding-2">

              <h3>Placement Cell Statistics</h3>
              <div class="row">
                                <div class="col-md-6">
                  <div class="info-box bg-c-yellow">
                    <span class="info-box-icon bg-green"><i class="ion ion-person-stalker"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Registered Students</span>
                      <?php
                      $sql = "SELECT * FROM users WHERE active='1' and college_name='{$_SESSION['college']}'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                      ?>
                      <span class="info-box-number"><?php echo $totalno; ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box bg-c-yellow">
                    <span class="info-box-icon bg-green"><i class="ion ion-person-stalker"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Pending Students Confirmation</span>
                      <?php
                      $sql = "SELECT * FROM users WHERE active='2'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $Ptotalno = $result->num_rows;
                      } else {
                        $Ptotalno = 0;
                      }
                      ?>
                      <span class="info-box-number"><?php echo $Ptotalno; ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box bg-c-yellow">
                    <span class="info-box-icon bg-red"><i class="ion ion-briefcase"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Placed</span>
                      <?php
                      $sql = "SELECT * FROM users INNER JOIN apply_job_post ON users.id_user=apply_job_post.id_user  WHERE apply_job_post.status = '0' and users.college_name='{$_SESSION['college']}'";
                     $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $Placed_totalno = $result->num_rows;
                      } else {
                        $Placed_totalno = 0;
                      }
                      ?>
                      <span class="info-box-number"><?php echo $Placed_totalno; ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box bg-c-yellow">
                    <span class="info-box-icon bg-red"><i class="ion ion-briefcase"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Yet to place</span>
                      <?php
                      $sql = "SELECT * FROM users left JOIN apply_job_post ON users.id_user=apply_job_post.id_user  WHERE apply_job_post.status != '0' or users.college_name='{$_SESSION['college']}'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $Ytotalno = $result->num_rows;
                      } else {
                        $Ytotalno = 0;
                      }
                      $Ytotalno=$totalno-$Placed_totalno;
                      ?>
                      <span class="info-box-number"><?php echo $Ytotalno; ?></span>

                    </div>
                  </div>
                </div>
                <div class="container">
   
        <div id="container"></div>
   
    <img class="center-block" src="https://codingbirdsonline.com/wp-content/uploads/2019/12/cropped-coding-birds-favicon-2-1-192x192.png" width="50">
 </div>
                      <script>
    // Build the chart
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Programming Language Popularity, 2020'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Popularity',
            colorByPoint: true,
            data: [
                {
                  name:'chrome',
                  y:64,
                  sliced:true,
                  selected:true;
                },
                {
                  name:"efge",
                  y=36
                }
            ]
        }]
    });
</script>

                   

        

            </div>
          </div>
        </div>
      </section>



    </div>
    <!-- /.content-wrapper -->
  
    <footer class="main-footer" style="margin-left: 0px;">
      <div class="text-center">
        <strong>Copyright &copy; 2022 <a href="learningfromscratch.online">Placement Portal</a>.</strong> All rights
        reserved.
      </div>
    </footer>

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../js/adminlte.min.js"></script>
</body>

</html>