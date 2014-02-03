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
    <button type="submit" class="btn btn-success">Login</button>
</form>