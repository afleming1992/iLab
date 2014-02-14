<script>
    function showPasswords()
    {
        $("#password_fields").fadeIn(1000).removeClass("hidden");
        return true;
    }

    function hidePasswords()
    {
        $("#password_fields").fadeOut(1000).addClass("hidden");
        return true;
    }

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
        var errorCount = 0;

        var password1 = $("#new_password1").val();
        var password2 = $("#new_password2").val();

        if($('input[name=choose_password]:checked', '#editUserForm').val() == "yes")
        {
            if(password1.length > 5)
            {
                if(password1 != password2)
                {
                    errorCount++;
                    $("#new_password_control1").addClass('has-error');
                    $("#new_password_control2").addClass('has-error');
                    $("#new_password_help").html("Passwords don't match!");

                }
                else
                {
                    $("#new_password_control1").removeClass('has-error');
                    $("#new_password_control2").removeClass('has-error');
                    $("#new_password_help").html("");
                }
            }
            else
            {
                $("#new_password_control1").addClass('has-error');
                $("#new_password_control2").addClass('has-error');
                $("#new_password_help").html("Passwords must be at least 6 Characters long");
                errorCount++;
            }
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
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Edit <?php echo $user->getUsername(); ?></h3>
    </div>
    <div class="panel-body">
        <form enctype="multipart/form-data" method="post" id="editUserForm" action="index.php" onsubmit="return validateForm();">
                <label for="choose_password">Do you wish to reset your password?</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="choose_password" id="choose_password" value="no" onClick="return hidePasswords();" checked>
                        No
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="choose_password" id="choose_password" value="yes" onClick="return showPasswords();">
                        Yes
                    </label>
                </div>
                <div id="password_fields" class="well hidden">
                    <div id='new_password_control1' class="form-group">
                        <label for="new_password1">New Password</label>
                        <input type="password" class="form-control" id="new_password1" name="new_password1" />
                    </div>
                    <div id='new_password_control2' class="form-group">
                        <label for="new_password2">Re-enter New Password</label>
                        <input type="password" class="form-control" id="new_password2" name="new_password2" />
                        <span class="help-block" id="new_password_help"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="profile_realname">Full Name</label>
                    <input type="text" class="form-control" name="profile_realname" id="profile_realname" value="<?php echo $user->getProfile()->getRealName(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="profile_role">Role</label>
                    <input type="text" class="form-control" name="profile_role" id="profile_role" value="<?php echo $user->getProfile()->getRole();?>"/>
                </div>
                <div class="form-group">
                    <label for="profile_email">Email</label>
                    <input type="email" class="form-control" name="profile_email" id="profile_email" value="<?php echo $user->getProfile()->getEmail(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="profile_website">Website</label>
                    <input type="text" class="form-control" name="profile_website" id="profile_website" value="<?php echo $user->getProfile()->getWebsite(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="profile_bio">A little about you!</label>
                    <textarea id="tinymce" id="profile_bio" name="profile_bio"><?php echo $user->getProfile()->getBio(); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="profile_pure">Research Gateway ID</label>
                    <input type="text" class="form-control" name="profile_pure" id="profile_pure" value="<?php echo $user->getProfile()->getPureId(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="profile_twitter">Twitter Username</label>
                    <div class="input-group">
                        <span class="input-group-addon">@</span>
                        <input type="text" class="form-control" name="profile_twitter" id="profile_twitter" value="<?php echo $user->getProfile()->getTwitter(); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="profile_scholar">Google Scholar Link</label>
                    <input type="text" class="form-control" name="profile_scholar" id="profile_scholar" value="<?php echo $user->getProfile()->getScholar(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="profile_linkedin">Linkedin Profile Link</label>
                    <input type="text" class="form-control" name="profile_linkedin" id="profile_linkedin" value="<?php echo $user->getProfile()->getLinkedIn(); ?>"/>
                </div>
                <div class="media">
                    <a class="pull-left" href="#">
                        <?php
                            if(file_exists("images/profile/".$user->getProfile()->getPhoto()))
                            {
                                ?>
                                     <img width="100px" height="100px" class="media-object" src="images/profile/<?php echo $user->getProfile()->getPhoto(); ?>">
                                <?php
                            }
                            else
                            {
                                ?>
                                    <img width="100px" height="100px" class="media-object" src="images/test-profile.jpg">
                                <?php
                            }
                        ?>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">This is your current Profile Picture</h4>
                        <label for="new_photo">Do you wish to change your Profile Photo?</label>
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
                <div id="photo_fields" class="well hidden">
                    <div class="form-group">
                        <label for="profile_photo">New Photo</label>
                        <input type="file" class="form-control" id="profile_photo" name="profile_photo" />
                    </div>
                </div>
                <input type="hidden" name="editUser" value="1"/>
                <?php
                    if($_GET['mode'] == "admin")
                    {
                        ?>
                             <div class="well">
                                 <h4>Administrator Settings</h4>
                                 <div class="form-group">
                                     <label for="access_level">Access Level</label>
                                     <select name="access_level" class="form-control">
                                         <option value="0" <?php if($user->getAccessLevel() == 0){ echo "selected"; } ?>>iLab Staff</option>
                                         <option value="1" <?php if($user->getAccessLevel() == 1){ echo "selected"; } ?>>Clerical Staff</option>
                                         <option value="2" <?php if($user->getAccessLevel() == 2){ echo "selected"; } ?>>Administrator</option>
                                     </select>
                                     <div class="checkbox">
                                         <label>
                                             <input type="checkbox" name="user_hidden" <?php if($user->getHidden() == 1){ echo "checked";} ?>> Make this User Hidden?
                                         </label>
                                     </div>
                                 </div>
                             </div>
                            <input type="hidden" name="admin" value="1"/>
                      <?php
                    }
                ?>
                <input type="hidden" name="username" value="<?php echo $user->getUsername(); ?>" />
                <button class='btn btn-success' type="submit">Save Changes</button>
        </form>
    </div>
</div>