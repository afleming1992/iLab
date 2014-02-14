<script type="text/javascript">
    function validateForm()
    {
        $("#errorMessage").removeClass('hidden');
        $("#errorMessage").removeClass('alert-danger');
        $("#errorMessage").addClass('alert-info');
        $("#errorMessage").html("<h3>Loading...</h3>")

        var username = $("#user_username").val();
        var realName = $("#user_realname").val();
        var password1 = $("#user_password1").val();
        var password2 = $("#user_password2").val();
        var errorCount = 0;

        if(username.length == 0)
        {
            $("#username_control").addClass('has-error');
            $("#username_help").html("You have not specified a Username!");
            errorCount++;
        }
        else
        {
            if(validateUsername(username).length > 0)
            {
                $("#username_control").addClass('has-error');
                $("#username_help").html("This Username is already taken");
                errorCount++;
            }
            else
            {
                $("#username_control").removeClass('has-error');
                $("#username_help").html("");
            }
        }

        if(realName.length == 0)
        {
            $("#realName_control").addClass("has-error");
            $("#realName_help").html("You have not specified the Full Name of the new User");
            errorCount++;
        }
        else
        {
            $("#realName_control").removeClass("has-error");
            $("#realName_help").html("");
        }

        if(password1.length < 5)
        {
            $("#password1_control").addClass("has-error");
            $("#password1_help").html("Passwords must be at least 5 characters long");
            errorCount++;
        }
        else
        {
            if(password2.length < 5)
            {
                $("#password2_control").addClass("has-error");
                $("#password2_help").html("You must re-enter your password to confirm!");
                errorCount++;
            }
            else
            {
               if(password1 != password2)
               {
                   $("#password2_control").addClass("has-error");
                   $("#password2_help").html("Your passwords do not match");
                   errorCount++;
               }
               else
               {
                   $("#password1_control").removeClass("has-error");
                   $("#password2_control").removeClass("has-error");
                   $("#password1_help").html("");
                   $("#password2_help").html("");
               }
            }
        }

        if(errorCount > 0)
        {
            $("#errorMessage").removeClass('hidden');
            $("#errorMessage").removeClass('alert-info');
            $("#errorMessage").addClass('alert-danger');
            $("#errorMessage").html("<h3>Oh Dear!</h3>Please review your input! It is invalid!")
            return false;
        }
        else
        {
            $("#errorMessage").removeClass("alert-danger");
            $("#errorMessage").removeClass("alert-info");
            $("#errorMessage").addClass("alert-success");
            $("#errorMessage").html("<h3>Looking good!</h3>");
            return true;
        }
    }

    function validateUsername(username)
    {
        var availname=remove_whitespace(username);
        if(availname!='')
        {
            $('#username_help').fadeIn(400).html('<img src="images/ajaxloader.gif" />');

            var data = 'username='+ availname;
            var returnResult = "";
            $.ajax({
                'type': "POST",
                'url': "ajax/checkUsername.php",
                'async': false,
                'data': data,
                'cache': false,
                'success': function(result){
                    returnResult = result;
                }
            });

            return returnResult;
        }
        else
        {
            alert("I get here!");
        }
    }

    function remove_whitespace(input)
    {
        var input = input.replace(/^\s+|\s+$/,'');
        return input;
    }
</script>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Create a New User</h3>
    </div>
    <div class="panel-body">
        <form role="form" method="post" action="index.php" onsubmit="return validateForm()">
            <div id='username_control' class="form-group">
                <label for="user_username">Username</label>
                <input type="text" class="form-control" name="user_username" id="user_username" placeholder="Username">
                <p id="username_help" class="help-block"></p>
            </div>
            <div id="realName_control" class="form-group">
                <label for="user_realname">Full Name</label>
                <input type="text" class="form-control" name="user_realname" id="user_realname" placeholder="Full Name">
                <p id="realName_help" class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="user_email">Email</label>
                <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="user_access">User's Access Level</label>
                <select class="form-control" name="user_access" id="user_access">
                    <option value="0">iLab Staff</option>
                    <option value="1">Clerical</option>
                    <option value="2">Administrator</option>
                </select>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="user_hidden"> Make this User Hidden?
                </label>
            </div>
                <h3>Password</h3>
                    <div class="form-group" id="password1_control">
                        <label for="user_password1">Enter the Password you wish to use</label>
                        <input type="password" class="form-control" name="user_password1" id="user_password1" placeholder="">
                        <p class="help-block" id="password1_help"></p>
                    </div>
                    <div class="form-group" id="password2_control">
                        <label for="user_password2">Re-enter password to confirm</label>
                        <input type="password" class="form-control" name="user_password2" id="user_password2" placeholder="">
                        <p class="help-block" id="password2_help"></p>
                    </div>
            <input type="hidden" name="addUser" value="1" />
                <div id="errorMessage"  class="alert alert-danger hidden">
                    <h3>Oh no!</h3><p>Please review your input as it is invalid!</p>
                </div>
            <button type="submit" id='submitButton' class="btn btn-success">Create User</button>
        </form>
    </div>
</div>

