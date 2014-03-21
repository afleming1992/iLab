<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Create a News Article</h3>
    </div>
    <div class="panel-body">
        <form enctype="multipart/form-data" action="index.php" method="post">
            <div class="form-group">
                <label>Name of Article</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Title of News item" value="<?php if(isset($news)){ echo $news->getTitle(); }?>"/>
            </div>
            <div class="form-group">
                <label>Summary</label>
                <textarea name="summary" class="form-control" id="summary" placeholder="Short Summary of 50 words or less"><?php if(isset($news)){ echo $news->getSummary(); } ?></textarea>
            </div>
            <div class="form-group">
                <label>The Article</label>
                <textarea name="article" id="tinymce"><?php if(isset($news)){ echo $news->getContent(); } ?></textarea>
            </div>
            <?php
                if($_GET["mode"] == "edit")
                {
            ?>
            <div class="media">
                <a class="pull-left" href="#">
                    <?php echo $news->generateImage(); ?>
                </a>
                <div class="media-body">
                    <h4 class="media-heading">This is your current News Article Image</h4>
                    <label for="new_photo">Do you wish to change this?</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="image_choice" id="image" value="no" onClick="return hidePhoto();" checked>
                            No
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="image_choice" id="image" value="yes" onClick="return showPhoto();">
                            Yes
                        </label>
                    </div>
                </div>
                <div id="photo_fields" class="well hidden">
                    <div class="form-group">
                        <label for="profile_photo">Image</label>
                        <input type="file" class="form-control" id="image" name="image" />
                    </div>
                </div>
                <?php
                    }
                    else
                    {
                ?>
                <div id="photo_fields" class="well">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="news_image" />
                    </div>
                </div>
<?php
    }
    ?>
                <?php
                    if($_GET['mode'] == "edit")
                    {
                ?>
                    <input type="hidden" name="editNews" value="1" />
                    <input type="hidden" name="newsId" value="<?php echo $news->getId(); ?>" />
                        <button class="btn btn-success" type="submit">Edit News</button>
                <?php
                    }
                    else
                    {
                        ?>
                            <input type="hidden" name="createNews" value="1" />
                            <button class="btn btn-success" type="submit">Add News</button>
                        <?php
                    }
                ?>

        </form>
    </div>
</div>
<script>
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
        var title = $('#title').val();
        if(title.length > 0)
        {
            return true;
        }
        else
        {
            $('#title_help').html("Please enter a Title!");

            return false;
        }
    }
</script>

