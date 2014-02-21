</div>
<div class="footer centre-block navbar-default" style="text-align:center;">
    This is the Footer
</div>
<?php
    if(!isset($_SESSION['username']))
    {
?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Login to iLab Website</h4>
            </div>
            <div class="modal-body">
            <?php
               include('forms/login.php');
            ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php
    }
?>
</body>
</html>