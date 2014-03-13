<script type="text/javascript">
    function showFile()
    {
        $("#file_box").removeClass("hidden").fadeIn(400);
    }

    function hideFile()
    {
        $("#file_box").addClass("hidden");
    }

    function validateForm()
    {
        if($('#publication_title').val().length < 1)
        {
            $('#title_group').addClass("has-error");
            $('#title_help').html("You need a Title!");
            return false;
        }
        else
        {
            return true;
        }
    }
</script>
<div class="panel panel-success">
    <div class="panel-heading"><h3>Edit Publication</h3></div>
    <div class="panel-body">
        <div id="form_box">
            <form method="post" enctype="multipart/form-data" action="index.php">
                <div id="title_group" class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" id="publication_title" name="title" value="<?php echo $publication->getName() ?>"/>
                    <p id='title_help' class="help-block"></p>
                </div>
                <div class="form-group">
                    <label>Published In</label>
                    <input type="text" class="form-control" id="publication_publishedIn" name="publishedIn" value="<?php echo $publication->getPublishedIn() ?>" />
                </div>
                <div class="form-group">
                    <label>Publication Organisation</label>
                    <input type="text" class="form-control" id="publication_publisher" name="publisher" value="<?php echo $publication->getPublisher(); ?>" />
                </div>
                <div class="form-group">
                    <label for="publication_year">Year</label>
                    <input type="text" class="form-control" id="publication_year" name="year" placeholder="yyyy" value="<?php echo $publication->getYear(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="publication_abstract">Abstract</label>
                    <textarea class="form-control" id="publication_abstract" name="abstract" rows="5"><?php echo $publication->getAbstract() ?></textarea>
                </div>
                <div class="form-group">
                    <label>Publication Link</label>
                    <input type="text" class="form-control" id="publication_link" name="link" value="<?php echo $publication->getLink() ?>" />
                </div>
                <div class="form-group">
                    <p>Do you wish to upload an file to replace the above file?</p>
                    <label>
                        <input type="radio" name="file_choice" value="yes" onClick="showFile()"/>Yes
                    </label><br />
                    <label>
                        <input type="radio" name="file_choice" value="no" onClick="hideFile()" checked/>No
                    </label>
                </div>
                <div id="file_box" class="form-group hidden">
                    <label>Select your File for Upload</label>
                    <input type="file" class="form-control" id="publication_file" name="publication_file" />
                    <p id='file_help' class="help-block"></p>
                </div>
                <input type="hidden" name="publicationId" value="<?php echo $publication->getId(); ?>" />
                <input type="hidden" name="editPublication" value="1" />
                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</div>

