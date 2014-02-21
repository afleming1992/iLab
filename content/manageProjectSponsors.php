<script>
   function validateAddForm()
   {
       var name = $('#sponsor_name').val();

       if(name.length < 1)
       {
           $('#new_name_control').addClass("has-error");
           $('#new_name_help').html("You need to enter a Sponsor's Name");
           return false;
       }
       else
       {
           $('#new_name_control').removeClass("has-error");
           $('#new_name_help').html("");
           return true;
       }
   }
</script>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Sponsor/Partner Management for <?php echo $project->getName(); ?></h3>
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
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_add_sponsor">Add New Sponsor/Partner</button>
                    <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_add_existing">Add Existing/Partner Sponsor to this Project</a>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <div id="sponsorList">
                    <?php
                        if(count($sponsors) == 0)
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
                                    <tr><th>Logo</th><th>Name</th><th>Type</th><th>Actions</th></tr>
                                    <?php
                                        foreach($sponsors as $sponsor)
                                        {
                                            ?>
                                                <tr><td><img src="<?php echo $sponsor["sponsor"]->getFullLogo(); ?>" style="max-width:100px;max-height:100px;"/></td><td><?php echo $sponsor["sponsor"]->getName(); ?></td><td><?php echo $sponsor["type"]; ?></td><td><a alt="Switch type" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-refresh"></span></a><a class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span></a><a href="?mode=remove&type=sponsorLink&sponsorId=<?php echo $sponsor['sponsor']->getId(); ?>&projectId=<?php echo $project->getId(); ?>" class="btn btn-danger btn-sm"><span class="
glyphicon glyphicon-remove"></span></a></td></tr>
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
<!-- Add Sponsor Modal -->
<div class="modal fade" id="modal_add_sponsor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Sponsor/Partner</h4>
            </div>
            <div class="modal-body">
               <form enctype="multipart/form-data" method="post" value="index.php" onSubmit="return validateAddForm()">
                   <div id="new_name_control" class="form-group">
                       <label for="sponsor_name">Name</label>
                       <input class="form-control" type="text" id="sponsor_name" name="sponsor_name" />
                       <p id='#new_name_help' class="help-block">Testing</p>
                   </div>
                   <div id="new_website_control" class="form-group">
                       <label for="sponsor_website">Website</label>
                       <input class="form-control" type="text" id="sponsor_website" name="sponsor_website" />
                   </div>
                   <div id="new_logo_control" class="form-group">
                       <label for="sponsor_logo">Logo</label>
                       <input class="form-control" type="file" id="sponsor_logo" name="sponsor_logo" />
                   </div>
                   <div class="form-group">
                       <label for="sponsor_type">Type</label>
                       <select class="form-control" name="sponsor_type">
                           <option value="sponsor">Sponsor</option>
                           <option value="partner">Partner</option>
                       </select>
                   </div>
                   <input type="hidden" name="projectId" value="<?php echo $project->getId(); ?>" />
                   <input type="hidden" name="addSponsor" value="1" />
                   <button class="btn btn-success" type="submit">Add Sponsor/Partner</button>
               </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Existing Sponsor Modal -->
<div class="modal fade" id="modal_add_existing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Existing Sponsor/Partner</h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="post" value="index.php">
                    <div class="form-group">
                        <select name="sponsorId" class="form-control">
                            <?php
                                foreach($fullSponsorList as $sponsor)
                                {
                                    ?>
                                        <option value="<?php echo $sponsor->getId() ?>"><?php echo $sponsor->getName(); ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sponsor_type">Type</label>
                        <select class="form-control" name="sponsor_type">
                            <option value="sponsor">Sponsor</option>
                            <option value="partner">Partner</option>
                        </select>
                    </div>
                    <input type="hidden" name="projectId" value="<?php echo $project->getId(); ?>" />
                    <input type="hidden" name="addExistingSponsor" value="1" />
                    <button class="btn btn-success" type="submit">Add Sponsor/Partner</button>
                </form>
            </div>
        </div>
    </div>
</div>
