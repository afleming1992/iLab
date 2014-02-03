<div class="row col-md-14">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Login Successful</h3>
            </div>
            <div class="panel-body">
                <h4>Great! You're now logged in! Click below to go to your Profile!</h4>
                <br />
                <a class="btn btn-primary">Go to my Profile</a>
                <?php
                    if($_SESSION['access_level'] == 2)
                    {
                        ?>
                            <a class="btn btn-primary">Go to Administration</a>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>