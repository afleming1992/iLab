<form method='post' action='?mode=login' role="form">
    <div class="form-group">
        <label for="login_username">Username</label>
        <input type="input" class="form-control" id="login_username" name="login_username" placeholder="Username">
    </div>
    <div class="form-group">
        <label for="login_password">Password</label>
        <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
    </div>
    <input type="hidden" name="login" value="1" />
    <?php
        if($verification)
        {
    ?>
    <input type="hidden" name="bounce" value="1" />
    <input type="hidden" name="mode" value="<?php echo $_GET['mode']; ?>" />
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
    <?php
        }
    ?>
    <button type="submit" class="btn btn-success">Login</button>
</form>