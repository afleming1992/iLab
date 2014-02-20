<script>
    function showPhoto()
    {
        $("#photo_fields").fadeIn(1000).removeClass("hidden");
        return true;
    }

    function hidePhoto()
    {
        $("#photo_fields").fadeOut(1000).addClass("hidden");
        return true;
    }

    function validateForm()
    {
        var website = $("#project_website").val();
        var name = $("#project_name").val();
        var startDate = $("#project_startDate").val();
        var endDate = $("#project_endDate").val();

        var pattern =/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;

        var errorCount = 0;
        if(website.indexOf("http://") != -1 || website.indexOf("https://") != -1)
        {
            errorCount++;
            $("#website_control").addClass("has-error");
            $("#website_help").html("Please remove the http:// from the front of the website address");
        }
        else
        {
            $("#website_control").removeClass("has-error");
            $("#website_control").addClass("has-success");
            $("#website_help").html("Looks good!");
        }

        if(name.length < 1)
        {
            errorCount++;
            $("#name_control").addClass("has-error");
            $("#name_help").html("You need a Project Name!");
        }
        else
        {
            $("#name_control").removeClass("has-error");
            $("#name_control").addClass("has-success");
            $("#name_help").html("Looking good!");
        }

        if(!pattern.test(startDate))
        {
            errorCount++;
            $("#startDate_control").addClass("has-error");
            $("#startDate_help").html("Date not Valid Format (dd/mm/yyyy)")
        }
        else
        {
            $("#startDate_control").removeClass("has-error");
            $("#startDate_control").addClass("has-success");
            $("#startDate_help").html("Looking good!");
        }

        if(!pattern.test(endDate))
        {
            errorCount++;
            $("#endDate_control").addClass("has-error");
            $("#endDate_help").html("Date not Valid Format (dd/mm/yyyy)")
        }
        else
        {
            $("#endDate_control").removeClass("has-error");
            $("#endDate_control").addClass("has-success");
            $("#endDate_help").html("Looking good!");
        }



        if(errorCount > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
</script>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Edit Project</h3>
    </div>
    <div class="panel-body">
        <?php
            if(isset($error))
            {
                ?>
                    <div class="alert alert-danger">
                        <h2>Oh Dear!</h2>
                        <p><?php echo $error; ?></p>
                    </div>
                <?php
            }
        ?>
        <form enctype="multipart/form-data" role="form" method="post" action="index.php" onSubmit="return validateForm();">
            <div id="name_control" class="form-group">
                <label for="project_name">Name</label>
                <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Page Title" value="<?php if(isset($project)){ echo $project->getName(); }?>">
                <p id="name_help" class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="project_description">Description</label>
                <textarea name="project_description" id="tinymce"><?php if(isset($project)){ echo $project->getDescription(); }?></textarea>
            </div>
            <div id="website_control" class="form-group">
                <label for="tinymce">Website</label>
                <div class="input-group">
                    <span class="input-group-addon">http://</span>
                    <input type="text" class="form-control" id="project_website" name="project_website" value="<?php if(isset($project)){ echo $project->getWebsite(); }?>" />
                </div>
                <p id="website_help" class="help-block">Please don't add http:// at the front!</p>
            </div>
            <div id="startDate_control" class="form-group">
                <label for="project_startDate">Start Date</label>
                <input type="text" class="form-control" id="project_startDate" name="project_startDate" placeholder="" value="<?php if(isset($project)){ echo $project->sqlToNormal($project->getStartDate()); } ?>">
                <p class="help-block" id="startDate_help"></p>
            </div>
           <div id="endDate_control" class="form-group">
               <label for="project_endDate">End Date</label>
               <input type="text" class="form-control" id="project_endDate" name="project_endDate" placeholder="" value="<?php if(isset($project)){ echo $project->sqlToNormal($project->getEndDate()); } ?>" />
               <p class="help-block" id="endDate_help"></p>
           </div>
            <?php
                if($_GET["mode"] == "edit")
                {
            ?>
            <div class="media">
                <a class="pull-left" href="#">
                    <img style="max-height:200px;max-width:200px;" src="<?php echo $project->getFullLogo(); ?>" />
                </a>
            <div class="media-body">
                <h4 class="media-heading">This is your current Project Logo</h4>
                <label for="new_photo">Do you wish to change your Project Logo?</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="new_logo" id="new_logo" value="no" onClick="return hidePhoto();" checked>
                        No
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="new_logo" id="new_logo" value="yes" onClick="return showPhoto();">
                        Yes
                    </label>
                </div>
            </div>
            <div id="photo_fields" class="well hidden">
                <div class="form-group">
                    <label for="profile_photo">New Photo</label>
                    <input type="file" class="form-control" id="project_logo" name="project_logo" />
                </div>
            </div>
                <?php
                    }
                else
                {
            ?>
                    <div id="photo_fields" class="well">
                        <div class="form-group">
                            <label for="profile_photo">New Photo</label>
                            <input type="file" class="form-control" id="project_logo" name="project_logo" />
                        </div>
                    </div>
            <?php
                }
                if(strcmp($_GET['mode'],"create") == 0)
                {
                    ?>
                    <input type="hidden" name="createProject" value="1" />
                <?php
                }
                else if(strcmp($_GET['mode'],"edit") == 0)
                {
                    ?>
                    <input type="hidden" name="editProject" value="1" />
                    <input type="hidden" name="project_id" value="<?php if(isset($project)){echo $project->getId();} ?>" />
                <?php
                }
            ?>
            <button type="submit" class="btn btn-success"><?php if(strcmp($_GET['mode'],"create") == 0){ echo "Create Project"; } else { echo "Save Changes";} ?></button>
        </form>
    </div>
</div>
<script>
    $(function() {
        $("#project_startDate").datepicker({
            dateFormat:"dd/mm/yy"
                });
        $("#project_endDate").datepicker({
            dateFormat:"dd/mm/yy"
        });
    });
</script>
