<script type="text/javascript">
    function showFile()
    {
        $("#file_box").removeClass("hidden");
    }

    function hideFile()
    {
        $("#file_box").addClass("hidden");
    }
</script>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Create a New Publication</h3>
    </div>
    <div class="panel-body">
        <div id="form_box" class="well hidden">
            <form method="post" enctype="multipart/form-data" action="index.php">
                <div class="form-group">
                    <label for="publication_title">Title</label>
                    <input type="text" class="form-control" id="publication_title" name="publication_title" placeholder="Title" value="<?php echo $publication->getTitle(); ?>">
                </div>
                <div class="form-group">
                    <label for="publication_publishedIn">Published In</label>
                    <input type="text" class="form-control" id="publication_publishedIn" name="publication_publishedIn" value="<?php echo $publication->getPublishedIn(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="publication_publisher">Publication Organisation</label>
                    <input type="text" class="form-control" id="publication_publisher" name="publication_publisher" value="<?php echo $publication->getPublisher(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="publication_year">Year</label>
                    <input type="text" class="form-control" id="publication_year" name="publication_year" placeholder="yyyy" value="<?php echo $publication->getYear(); ?>" />
                </div>
                <div class="form-group">
                    <label for="publication_abstract">Abstract</label>
                    <textarea class="form-control" id="publication_abstract" name="publication_abstract" rows="5"><?php echo $publication->getAbstract(); ?></textarea>
                </div>
                <div class="form-group">
                    <h3>File Upload/Link</h3>
                    <input type="text" class="form-control" id="publication_link" name="publication_link" value="<?php echo $publication->getLink(); ?>" />
                    <br />
                    <p>Do you wish to upload a new file to the website?</p>
                    <input type="radio" name="file_choice" id="file_choice" value="yes" onClick="showFile()"/>
                    <input type="radio" name="file_choice" id="file_choice" value="no" onClick="hideFile()"/>
                </div>
                <div id="file_box" class="form-group hidden">
                    <label for="publication_file">Select the File you wish to upload</label>
                    <input type="file" class="form-control" name="publication_file" id="publication_file" />
                </div>
                <input type="hidden" name="editPublication" value="1" />
                <input type="hidden" name="publicationId" value="<?php echo $publication->getId(); ?>" />
                <button type="submit" id='submitButton' class="btn btn-success"><span class="glyphicon glyphicon-floppy-saved"></span> Create Publication</button>
        </div>
        </form>
    </div>
</div>

