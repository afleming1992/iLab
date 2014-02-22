<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Collaborator Management for <?php echo $project->getName(); ?></h3>
    </div>
    <div class="panel-body">
        <?php
            if(isset($error))
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                </div>
            <?php
            }

            if(isset($success))
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                </div>
            <?php
            }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <a class="btn btn-primary btn-sm" href="?mode=project&id=<?php echo $project->getId(); ?>">Back to Project View</a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_add_collaborator">Add New Collaborator</button>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <div id="sponsorList">
                    <?php
                        if(count($collaborators) == 0)
                        {
                            ?>
                            <div class="alert alert-info">
                                <b>There is currently no sponsors or partners assigned to this project</b><br />
                                You can add one by clicking the create Button above!
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <table class="table table-striped">
                                <tr><th>Profile Picture</th><th>Name</th><th>Admin?</th><th>Hidden?</th><th>Actions</th></tr>
                                <?php
                                    foreach($collaborators as $collaborator)
                                    {
                                        ?>
                                            <tr>
                                                <td><img style='max-width:75px;max-height:75px;' src='<?php echo $collaborator['user']->getProfile()->getFullPhoto(); ?>' /></td>
                                                <td><?php echo $collaborator['user']->getProfile()->getRealName(); ?></td>
                                                <td>
                                                    <?php
                                                        if($collaborator['admin'])
                                                        {
                                                            echo "<span class='green glyphicon glyphicon-ok'></span>";
                                                        }
                                                        else
                                                        {
                                                            echo "<span class='red glyphicon glyphicon-remove'></span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($collaborator['hidden'])
                                                        {
                                                            echo "<span class='green glyphicon glyphicon-ok'></span>";
                                                        }
                                                        else
                                                        {
                                                            echo "<span class='red glyphicon glyphicon-remove'></span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href='?mode=remove&type=collaborator&projectId=<?php echo $project->getId(); ?>&sponsorId=<?php echo $collaborator['user']->getUsername() ?>' class="btn btn-sm btn-danger">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                            </table>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Collaborator -->
<div class="modal fade" id="modal_add_collaborator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Collaborator</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="index.php">
                    <div class="form-control">
                        <label for="collaborator_username">Username</label>
                        <select name="collaborator_username">
                            <?php
                                foreach($nonContributors as $user)
                                {
                                    ?>
                                        <option value="<?php echo $user->getUsername() ?>"><?php echo $user->getProfile()->getRealName(); ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="collaborator_admin">Do you want this user to be an Admin?</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="collaborator_admin" id="collaborator_admin" value="1">
                                Yes
                            </label><br />
                            <label>
                                <input type="radio" name="collaborator_admin" id="collaborator_admin" value="0" checked>
                                No
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="collaborator_hidden">Do you want this user to be Hidden on this Project?</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="collaborator_hidden" id="collaborator_hidden" value="1">
                                Yes
                            </label><br />
                            <label>
                                <input type="radio" name="collaborator_hidden" id="collaborator_hidden" value="0" checked>
                                No
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="addCollaborator" value="1" />
                    <input type="hidden" name="projectId" value="<?php echo $project->getId(); ?>" />
                    <button type="submit" class="btn btn-success">Add Collaborator</button>
                </form>
            </div>
        </div>
    </div>
</div>