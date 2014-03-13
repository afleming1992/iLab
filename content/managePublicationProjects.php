<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Project Management for <?php echo $publication->getName(); ?></h3>
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
                    <a class="btn btn-primary btn-sm" href="?mode=publication&id=<?php echo $publication->getId(); ?>">Back to Publication View</a>
                </div>
                <div class="pull-right">
                    <?php
                        if(count($nonProjects) != 0)
                        {
                        ?>
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_add_project">Add Project</button>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <div id="sponsorList">
                    <table class="table table-bordered">
                        <tr><th>Logo</th><th>Name</th><th>Actions</th></tr>
                        <?php
                            foreach($projects as $project)
                            {
                                ?>
                                     <tr>
                                         <td><?php echo $project->generateLink(); ?></td>
                                         <td><?php echo $project->getName(); ?></td>
                                         <td><a class="btn btn-danger btn-block" href="?mode=delete&type=pub_project&pub_id=<?php echo $publication->getId(); ?>&id=<?php echo $project->getId(); ?>"><span class="glyphicon glyphicon-trash"</a></td>
                                     </tr>
                                <?php
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add New Author Modal -->
<div class="modal fade" id="modal_add_project" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Author</h4>
            </div>
            <div class="modal-body">
                <form method="post" >
                        <label for="project_select">
                            Select which Project you wish to add
                        </label>
                        <select id="project_select" name="project" class="form-control">
                            <?php
                                foreach($nonProjects as $project)
                                {
                                    ?>
                                        <option value="<?php echo $project->getId(); ?>"><?php echo $project->getName(); ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    <br />
                    <input type="hidden" name="publicationId" value="<?php echo $publication->getId() ?>" />
                    <input type="hidden" name="addPubProject" value="1" />
                    <button class="btn btn-success" type="submit">Add Project</button>
                </form>
            </div>
        </div>
    </div>
</div>