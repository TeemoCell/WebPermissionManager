<?php
include_once("config.php");

$GPP = mysqli_query($mysqli, "SELECT * FROM `permissions` ORDER BY `permissions`.`id` ASC "); 
$GP = mysqli_query($mysqli, "SELECT * FROM groups ORDER BY `groups`.`Priority` DESC"); 

$GG = mysqli_query($mysqli, "SELECT * FROM groups ORDER BY `groups`.`Priority` DESC"); 
$MGG = mysqli_query($mysqli, "SELECT * FROM groups ORDER BY `groups`.`Priority` DESC");

if( $_POST['DeletePermission'] ) {

    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
    $sql = "DELETE FROM `permissions` WHERE id = '$id'";;

    if(mysqli_query($mysqli, $sql)){
        $RESULT .= "<font color='green'>Successfully removed $Permission</font>";
        header('Location: index.php');
    } else{
        $RESULT .= "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
    }
}

if( $_POST['DeleteGroup'] ) {

    $ID = mysqli_real_escape_string($mysqli, $_POST['ID']);
    $sql = "DELETE FROM `groups` WHERE ID = '$ID'";

    if(mysqli_query($mysqli, $sql)){
        $RESULT .= "<font color='green'>Successfully removed $ID</font>";
        header('Location: index.php');
    } else{
        $RESULT .= "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
    }
}
if( $_POST['AddPermission'] ) {

    $Permission = mysqli_real_escape_string($mysqli, $_POST['Permission']);
    $TGroup = mysqli_real_escape_string($mysqli, $_POST['TGroup']);
    $Cooldown = mysqli_real_escape_string($mysqli, $_POST['Cooldown']);

    if(empty($Permission) | empty($Cooldown)) {
        if(empty($Permission)) {
            $ErrPermission.= 'has-error';
        }
        if(empty($Cooldown)) {
            $ErrCooldown.= 'has-error';
        }
    } else { 
        if (!($stmt = $mysqli->prepare("INSERT INTO `permissions`(`Permission`, `TGroup`, `Cooldown`) VALUES ('$Permission', '$TGroup', '$Cooldown')"))) {
            echo "ERROR: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            header('Location: index.php');
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->close();
        }
}

if( $_POST['AddGroup'] ) {
    $ID = mysqli_real_escape_string($mysqli, $_POST['ID']);
    $DisplayName = mysqli_real_escape_string($mysqli, $_POST['DisplayName']);
    $Color = mysqli_real_escape_string($mysqli, $_POST['Color']);
    $Prefix = mysqli_real_escape_string($mysqli, $_POST['Prefix']);
    $Suffix = mysqli_real_escape_string($mysqli, $_POST['Suffix']);
    $ParentGroup = mysqli_real_escape_string($mysqli, $_POST['ParentGroup']);
    $Priority = mysqli_real_escape_string($mysqli, $_POST['Priority']);

    if(empty($ID) | empty($DisplayName)| empty($Priority)) {
        if(empty($ID)) {
            $ErrID.= 'has-error';
        }
        if(empty($DisplayName)) {
            $ErrDisplayName.= 'has-error';
        }
        if(empty($Priority)) {
            $ErrPriority.= 'has-error';
        } 
    } else { 
        if (!($stmt = $mysqli->prepare("INSERT INTO `groups`(`ID`, `DisplayName`, `Color`, `Prefix`, `Suffix`, `ParentGroup`, `Priority`) VALUES  ('$ID', '$DisplayName', '$Color','$Prefix','$Suffix','$ParentGroup','$Priority')"))) {
            echo "ERROR: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            header('Location: index.php');
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->close();
        }
    }
    function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%ad %hh %im %ss');
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
                <div class="container-fluid">
                    <h1 class="mt-4 text-center">Manage Groups</h1><br>
                    <div class="row">
                        <div class="col-md-4">
                        <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Create New Group</div>
                                <div class="card-body">
                                    <form name="form" id="AddGroup" method="post" action="">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo $ErrID?>">
                                                    <input type="text" id="ID" name="ID" class="form-control text-center" placeholder="Group ID" onchange="document.getElementById('AID').innerHTML = this.value">                                        
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo $ErrDisplayName?>">
                                                    <input type="text" id="DisplayName" name="DisplayName" class="form-control text-center" placeholder="Display Name">                                        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="color" id="Color" name="Color" class="form-control text-center" placeholder="Color">                                        
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo $ErrPriority?>">
                                                    <input type="number" id="Priority" name="Priority" class="form-control text-center" placeholder="Priority">
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <input type="text" id="Prefix" name="Prefix" class="form-control text-center" placeholder="Prefix">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" id="Suffix" name="Suffix" class="form-control text-center" placeholder="Suffix">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="col-md-3"> </div>
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <select id="ParentGroup" name="ParentGroup" name="select" class="form-control">
                                                            <option value="0">Select Parent Group</option>
                                                        <?php while($Show = mysqli_fetch_array($MGG)) {  ?>
                                                            <option value="<?php echo $Show['ID'] ?>"><b><?php echo $Show['ID'] ?></b> - <?php echo $Show['DisplayName'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="AddGroup" id="AddGroup" class="btn btn-sm btn-outline-secondary btn-block" value="Submit">Create <b><span id="AID"></span></b></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>View, Edit and Remove Groups</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="GroupManager" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Display Name</th>
                                                    <th>Color</th>
                                                    <th>Prefix</th>
                                                    <th>Suffix</th>
                                                    <th>Parent Group</th>
                                                    <th>Priority</th>
                                                    <th style="width: 73px;" class="text text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php while($Show = mysqli_fetch_array($GG)) {  ?>
                                                <tr>
                                                    <td><?php echo $Show['ID'] ?></td>
                                                    <td><?php echo $Show['DisplayName'] ?></td>
                                                    <td><?php echo $Show['Color'] ?></td>
                                                    <td><?php echo $Show['Prefix'] ?></td>
                                                    <td><?php echo $Show['Suffix'] ?></td>
                                                    <td><?php echo $Show['ParentGroup'] ?></td>
                                                    <td><?php echo $Show['Priority'] ?></td>
                                                    <td>
                                                        <form name="form" id="DeleteGroup" method="post" action="">
                                                            <input hidden id="ID" name="ID" class="form-control text-center" value="<?php echo $Show['ID'];?>">
                                                            <a class="btn btn-outline-success btn-sm" href="EditGroup.php?Group=<?php echo $Show['ID'];?>"><i class="lni lni-pencil"></i></a>
                                                            <button class="btn btn-outline-danger btn-sm" type="submit" value="Submit" name="DeleteGroup"><i class='lni lni-close'></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h1 class="mt-4 text-center">Manage Permission</h1><br>
                    <div class="row">
                        <div class="col-md-4">
                        <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Add New Permission to Group</div>
                                <div class="card-body">
                                    <form class="form-horizontal" name="form" id="AddPermission" method="post" action="">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group <?php echo $ErrPermission?>">
                                                    <input type="text" id="Permission" name="Permission" class="form-control text-center" placeholder="Permission" onchange="document.getElementById('APermission').innerHTML = this.value">                                        
                                                </div> 
                                            </div>
                                            <div class="col-4"> 
                                                <div class="form-group">
                                                    <select id="TGroup" name="TGroup" name="select" class="form-control" onchange="document.getElementById('ATGroup').innerHTML = this.value">
                                                            <option value="0">Select Group</option>
                                                        <?php while($Show = mysqli_fetch_array($GP)) {  ?>
                                                            <option value="<?php echo $Show['ID'] ?>"><?php echo $Show['ID'] ?> - <?php echo $Show['DisplayName'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group <?php echo $ErrCooldown?>">
                                                    <input type="number" id="Cooldown" name="Cooldown" class="form-control text-center" placeholder="Cooldown">
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="AddPermission" id="AddPermission" class="btn btn-sm btn-outline-secondary btn-block" value="Submit">Add  <b><span id="APermission"></span></b> to <b><span id="ATGroup"></span></b></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>View, Edit and Remove Permission</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="PermissionManager" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Permission</th>
                                                    <th>TGroup</th>
                                                    <th>Cooldown</th>
                                                    <th style="width: 73px;" class="text text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($Show = mysqli_fetch_array($GPP)) {  ?>
                                                    <tr>
                                                        <td><?php echo $Show['Permission'] ?></td>
                                                        <td><?php echo $Show['TGroup'] ?></td>
                                                        <td><?php echo secondsToTime($Show['Cooldown']); ?></td>
                                                        <td>
                                                            <form name="form" id="DeletePermission" method="post" action="">
                                                                <input hidden id="id" name="id" class="form-control text-center" value="<?php echo $Show['id'];?>">
                                                                <a class="btn btn-outline-success btn-sm" href="EditPermission?id=<?php echo $Show['id'];?>"><i class="lni lni-pencil"></i></a>
                                                                <button class="btn btn-outline-danger btn-sm" type="submit" value="Submit" name="DeletePermission"><i class='lni lni-close'></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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
        <script>
            $(document).ready(function() {
                $('#GroupManager').DataTable({
                    paging:   true,
                    ordering: true,
                    info:     false,
                    searching: true,
                    lengthChange: false,
                    lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
                    'columnDefs': [ {
                    'targets': [7], 
                    'orderable': false,
                    }]
                });

                $('#PermissionManager').DataTable({
                    paging:   true,
                    ordering: true,
                    info:     false,
                    searching: true,
                    lengthChange: false,
                    lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
                    'columnDefs': [ {
                    'targets': [3], 
                    'orderable': false,
                    }]
                });
            });
        </script>
    </body>
</html>