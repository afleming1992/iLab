<form method='post' action='?mode=login' role="form">
    <div class="form-group">
        <label for="login_username">Username</label>
        <input type="input" class="form-control" id="login_username" name="login_username" placeholder="Username">
    </div>
    <div class="form-group">
        <label for="login_password">Password</label>
        <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
    </div>
    <div class="form-group">
        <label>
            Remember me <input type="checkbox" name="remember" value="1" />
        </label>
    </div>
    <input type="hidden" name="login" value="1" />
    <?php
        if($verification)
        {
    ?>
    <input type="hidden" name="bounce" value="1" />
    <input type="hidden" name="returnurl" value="<?php echo $_SERVER['QUERY_STRING']; ?>" />
    <?php
        }
    ?>
    <button type="submit" class="btn btn-success">Login</button>
</form>