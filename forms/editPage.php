<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Create a New Page</h3>
    </div>
    <div class="panel-body">
        <form role="form">
            <div class="form-group">
                <label for="page_title">Title</label>
                <input type="text" class="form-control" name="page_title" id="page_title" placeholder="Page Title">
            </div>
            <div class="form-group">
                <label for="page_section">Section</label>
                <select name="page_section" id="page_section" class="form-control">
                    <?php
                        echo $sections;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tinymce">Content</label>
                <textarea name="pagecontent" id="tinymce"></textarea>
            </div>
            <div class="form-group">
                <label for="page_module">Embeddable Module Name</label>
                <input type="text" class="form-control" id="page_module" name="page_module" placeholder="">
                <p>This is the name of the file in the modules folder that you want included into the page</p>
            </div>
            <div class="form-group">
                <label for="page_restricted">Restrict Access to this Page? <input name="page_restricted" type="checkbox"> </label>
            </div>
            <button type="submit" class="btn btn-default"><?php if(strcmp($_GET['mode'],"create") == 0){ echo "Create Page"; } else { echo "Save Changes";} ?></button>
        </form>
    </div>
</div>

