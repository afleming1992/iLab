<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">User List</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr><th>Photo</th><th>Username</th><th>Real Name</th><th>Actions</th></tr>
            <?php
                foreach($users as $user)
                {
                    ?>
                        <tr>
                            <td>
                                <img width='50px' height='50px' class='img-thumbnail' src='<?php if(file_exists("images/profile/".$user->getProfile()->getPhoto()) && strlen($user->getProfile()->getPhoto()) > 0){ echo "images/profile/".$user->getProfile()->getPhoto();}else{ echo "images/test-profile.jpg";} ?>' />
                            </td>
                            <td>
                                <?php echo $user->getUserName(); ?>
                            </td>
                            <td>
                                <?php echo $user->getProfile()->getRealName(); ?>
                            </td>
                            <td width="166px">
                                <a class="btn btn-warning" href="?mode=admin&action=editUser&id=<?php echo $user->getUsername(); ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <a class="btn btn-danger" href="?mode=admin&action=deleteUser&id=<?php echo $user->getUsername(); ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </table>
    </div>
</div>
