<?php
include_once("config.php");
$MGG = mysqli_query($mysqli, "SELECT * FROM groups");

$Group = $_GET['Group'];
$GetInfoD = mysqli_query($mysqli, "SELECT * FROM groups WHERE ID = '$Group'");

while($res = mysqli_fetch_array($GetInfoD))
{    
    $ID = $res['ID'];
    $DisplayName = $res['DisplayName'];
    $Color = $res['Color'];
    $Prefix = $res['Prefix'];
    $Suffix = $res['Suffix'];
    $ParentGroup = $res['ParentGroup'];
    $Priority = $res['Priority'];
}

if(isset($_POST['UpdateGroup']))
{    
    $Group = $_GET['Group'];

    $ID = $res['ID'];
    $DisplayName = $res['DisplayName'];
    $Color = $res['Color'];
    $Prefix = $res['Prefix'];
    $Suffix = $res['Suffix'];
    $ParentGroup = $res['ParentGroup'];
    $Priority = $res['Priority'];     

    $sql = mysqli_query($mysqli, "UPDATE `groups` SET `ID` = '$ID', `DisplayName` = '$DisplayName', `Color` = '$Color', `Prefix` = '$Prefix', `Suffix` = '$Suffix', `ParentGroup` = '$ParentGroup', `Priority` = '$Priority' WHERE `ID` = '$Group'");
    
    if(mysqli_query($mysqli, $sql)){
        header('Location: index.php');
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
    }                                            
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Web Permission Manager</title>
        <link href="assets/css/main.css" rel="stylesheet" />
        <link href="assets/css/LineIcons.css" rel="stylesheet" />
        <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    </head>
    <body class="sb-nav-fixed">
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <div class="container-fluid"><br><br><br><br><br>
                    <div class="row">
                    <div class="col-md-3"></div>
                        <div class="col-md-6">
                        <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Edit <b class="text-danger"><?php echo $DisplayName;?></b></div>
                                <div class="card-body">
                                    <form name="form" method="post" id="UpdateGroup" action="">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" id="ID" name="ID" class="form-control text-center" value="<?php echo $ID;?>" onchange="document.getElementById('AID').innerHTML = this.value">                                        
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" id="DisplayName" name="DisplayName" class="form-control text-center" value="<?php echo $DisplayName;?>">                                        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="color" id="Color" name="Color" class="form-control text-center" value="<?php echo $Color;?>">                                        
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" id="Priority" name="Priority" class="form-control text-center" value="<?php echo $Priority;?>">
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <input type="text" id="Prefix" name="Prefix" class="form-control text-center" value="<?php echo $Prefix;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" id="Suffix" name="Suffix" class="form-control text-center" value="<?php echo $Suffix;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="col-md-3"> </div>
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <select id="ParentGroup" name="ParentGroup" name="select" class="form-control">
                                                            <option selected value="<?php echo $ParentGroup;?>"><?php echo $ParentGroup;?></option>
                                                        <?php while($Show = mysqli_fetch_array($MGG)) {  ?>
                                                            <option value="<?php echo $Show['ID'] ?>"><b><?php echo $Show['ID'] ?></b> - <?php echo $Show['DisplayName'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="UpdateGroup" class="btn btn-sm btn-outline-secondary btn-block" value="Submit">Update <b><span id="AID"></span></b></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    </body>
</html>