<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Author Management for <?php echo $publication->getName(); ?></h3>
    </div>
    <div class="panel-body">
        <?php
            if(isset($error))
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                </div>
            <?php
            }

            if(isset($success))
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                </div>
            <?php
            }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <a class="btn btn-primary btn-sm" href="?mode=publication&id=<?php echo $publication->getId(); ?>">Back to Publication View</a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_add_author">Add New Collaborator</button>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <div id="sponsorList">
                    <table class="table table-bordered">
                        <tr><th>Photo</th><th>Name</th><th>Actions</th></tr>
                        <?php
                            foreach($authors as $author)
                            {
                                if(is_string($author['author']))
                                {
                                    ?>
                                        <tr><td></td><td><?php echo $author['author']; ?></td><td><a class='btn btn-block btn-danger' href="?mode=delete&type=author&id=<?php echo $author['id'] ?>&pubId=<?php echo $publication->getId(); ?>"><span class="glyphicon-trash glyphicon"></span></a></td></tr>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                        <tr><td><?php echo $author['author']->getProfile()->generateProfileLink(); ?></td><td><?php echo $author['author']->getProfile()->getRealName(); ?></td><td><a class='btn btn-block btn-danger' href="?mode=delete&type=author&id=<?php echo $author['id'] ?>&pubId=<?php echo $publication->getId(); ?>"><span class="glyphicon-trash glyphicon"></span></a></td></tr>
                                    <?php
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add New Author Modal -->
<div class="modal fade" id="modal_add_author" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Author</h4>
            </div>
            <div class="modal-body">
                <form method="post" onSubmit="return formValidation()">
                    <div class="author_choice_box">
                        <p>Is the person you wish to add have an Account on this Website?</p>
                        <label>
                             <input type="radio" id="author_choice_yes" name="author_choice" value="yes" onClick="showUserBox()" />
                              Yes
                        </label><br />
                        <label>
                            <input type="radio" id="author_choice_no" name="author_choice" value="no" onClick="showNonUserBox()" />
                            No
                        </label>
                    </div>
                    <div class="well hidden" id="non_ilab_box">
                        <div class="form-group" id="non_user_validation">
                            <label for="non_user">
                                Please enter the name of the Person you wish to add
                            </label>
                            <input id="non_user" name="non_author" class="form-control" />
                            <p id="non_user_help" class="help-block"></p>
                        </div>
                    </div>
                    <div class="well hidden" id="ilab_box">
                        <label for="user_select">
                            Select which User you want to add as an Author
                        </label>
                        <select id="user_select" name="ilab_author" class="form-control">
                            <?php
                                foreach($ilabUsers as $user)
                                {
                                    ?>
                                        <option value="<?php echo $user->getUsername(); ?>"><?php echo $user->getProfile()->getRealName(); ?> <em>(<?php echo $user->getUsername() ?>)</em></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <br />
                    <input type="hidden" name="publicationId" value="<?php echo $publication->getId() ?>" />
                    <input type="hidden" name="addAuthor" value="1" />
                    <button class="btn btn-success" type="submit">Add Author</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function hideBoxes()
    {
        $("#ilab_box").addClass("hidden");
        $("#non_ilab_box").addClass("hidden");
    }

    function showUserBox()
    {
        hideBoxes();
        $("#ilab_box").removeClass("hidden");
    }

    function showNonUserBox()
    {
        hideBoxes();
        $("#non_ilab_box").removeClass("hidden");
    }

    function formValidation()
    {
        var author_choice = $('input[name="author_choice"]:checked').val();
        if(author_choice == "no")
        {
            if($('#non_user').val().length > 0)
            {
                return true;
            }
            else
            {
                $('#non_user_validation').addClass("has-error");
                $('#non_user_help').html("You must enter something in this box!");
                return false;
            }
        }
        else
        {
            return true;
        }
    }
</script>