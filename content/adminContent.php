<div class="row col-md-14">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">
                    Navigation
                </h1>
            </div>
            <div class="panel-body" style="padding:0">
                <ul class="nav nav-pills nav-stacked">
                    <li class="nav-header disabled"><a><span class="glyphicon glyphicon-user"></span> Users</a></li>
                    <li class="<?php if($action == "addUser"){ echo "active"; }?>"><a href="?mode=admin&action=addUser"><span class="glyphicon glyphicon-plus-sign"></span> Add User</a></li>
                    <li class="<?php if($action == "userList"){ echo "active"; }?>"><a href="?mode=admin&action=userList"><span class="glyphicon glyphicon-list"></span> User List</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                    if($action == "addUser")
                    {
                        include("forms/addUser.php");
                    }
                    else if($action == "userList")
                    {
                        include("content/userList.php");
                    }
                    else if($action == "editUser")
                    {
                        include("forms/editUser.php");
                    }
                    else
                    {
                        ?>
                            <h2>Welcome to Administration</h2>
                            <p>Please select an option from the left</p>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>