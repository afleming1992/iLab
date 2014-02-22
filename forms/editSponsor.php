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

    function showPhoto()
    {
        $('#new-photo').removeClass("hidden");
    }

    function hidePhoto()
    {
        $('#new-photo').addClass("hidden");
    }
</script>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Edit a Sponsor</h3>
    </div>
    <div class="panel-body">
        <form enctype="multipart/form-data" method="post" value="index.php" onSubmit="return validateAddForm()">
            <div id="new_name_control" class="form-group">
                <label for="sponsor_name">Name</label>
                <input class="form-control" type="text" id="sponsor_name" name="sponsor_name" value="<?php if(isset($sponsor)){ echo $sponsor->getName();} ?>" />
                <p id='#new_name_help' class="help-block"></p>
            </div>
            <div id="new_website_control" class="form-group">
                <label for="sponsor_website">Website</label>
                <input class="form-control" type="text" id="sponsor_website" name="sponsor_website" value="<?php if(isset($sponsor)){ echo $sponsor->getWebsite();} ?>" />
            </div>
            <div class="media">
                <a class="pull-left" href="#">
                    <img style="max-width:75px;max-height:75px;" src='<?php
                        echo $sponsor->getFullLogo();
                    ?>' />
                </a>
                <div class="media-body">
                    <h4 class="media-heading">This is your current Sponsor Logo</h4>
                    <label for="new_photo">Do you wish to change your Sponsor Logo?</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="new_photo" id="new_photo" value="no" onClick="return hidePhoto();" checked>
                                No
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="new_photo" id="new_photo" value="yes" onClick="return showPhoto();">
                               Yes
                        </label>
                    </div>
                </div>
            </div>
            <div id='new-photo' class="well hidden">
                <div id="new_logo_control" class="form-group">
                    <label for="sponsor_logo">Logo</label>
                    <input class="form-control" type="file" id="sponsor_logo" name="sponsor_logo" />
                </div>
            </div>
            <input type="hidden" name="sponsorId" value="<?php if(isset($sponsor)){ echo $sponsor->getId();} ?>"/>
            <input type="hidden" name="editSponsor" value="1" />
            <input type="hidden" name="project" value="<?php echo $_GET['project']; ?>" />
            <button class="btn btn-success" type="submit">Edit Sponsor/Partner</button>
        </form>
    </div>
</div>

