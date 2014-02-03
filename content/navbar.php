<nav class="mainnav navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
      <span class='sr-only'>Toggle Navigation</span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>
    <a class='navbar-brand' href='index.php'><img src='images/logo.png' height='55px'/></a>
  </div>
    <ul class='nav navbar-nav'>
      <li><a href='index.php'>Home</a></li>
        <?php
            print $navigation;
        ?>
    </ul>
    <?php
        if(isset($_SESSION['login']))
        {
    ?>
        <div class="btn-group" style='float:right;'>
            <button id="navbar_profile" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" style='padding:5px'">
               <?php
                    $user = new Profile($this->db,$_SESSION['username']);
                    $user->getProfile();
                    $photo = 'images/test-profile.jpg';
                    if(strlen($user->getPhoto()) > 0)
                    {
                        $photo = $user->getPhoto();
                    }
                ?>
                <img src="<?php echo $photo ?>" class="img-thumbnail" width="50px" height="50px" style="margin:0" /> <span class="caret"></span>
            </button>
                <ul class="dropdown-menu" role="menu">
                    <li role="presentation" class="dropdown-header">Quick Access</li>
                    <li><a href="#">My Profile</a></li>
                    <li><a href="#">My Publications</a></li>
                    <li class="divider"></li>
                    <?php
                        if($_SESSION['access_level'] == 2)
                        {
                    ?>
                    <li role="presentation" class="dropdown-header">Administration</li>
                    <li><a href="#">Go to Admin</a></li>
                    <li class="divider"></li>
                    <?php
                        }
                    ?>
                    <li role="presentation" class="dropdown-header">Logout</li>
                    <li><a href="?logout=1">LOGOUT</a></li>
                </ul>

        </div>
    <?php
        }
        else
        {
    ?>
    <button id='navbar_profile' type="button" class="btn btn-primary dropdown-toggle" data-toggle="modal" data-target="#loginModal" style='float:right;'>
        Login <span class='glyphicon glyphicon-lock'></span>
    </button>
    <?php
        }
    ?>
</nav>