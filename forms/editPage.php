<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Create a New Page</h3>
    </div>
    <div class="panel-body">
        <form role="form" method="post" action="index.php">
            <div class="form-group">
                <label for="page_title">Title</label>
                <input type="text" class="form-control" name="page_title" id="page_title" placeholder="Page Title" value="<?php if(isset($page)){ echo $page->getTitle(); }?>">
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
                <textarea name="page_content" id="tinymce"><?php if(isset($page)){ echo $page->getContent(); }?></textarea>
            </div>
            <div class="form-group">
                <label for="page_module">Embeddable Module Name</label>
                <input type="text" class="form-control" id="page_module" name="page_module" placeholder="" value="<?php if(isset($page)){ echo $page->getModule(); } ?>">
                <p>This is the name of the file in the modules folder that you want included into the page</p>
            </div>
            <div class="form-group">
                <label for="page_restricted">Restrict Access to this Page? <input name="page_restricted" type="checkbox" <?php if(isset($page)){ if($page->getRestricted()){ echo "checked"; }}?>> </label>
                <?php
                    if(isset($page))
                    {
                        if($page->getSectionHomepage())
                        {
                         ?>
                            <br />This page is currently the Section Homepage. To change this, please go to another page to make it the Homepage
                         <?php
                        }
                        else
                        {
                            ?>
                            <br /><label for="homepage">Make this Page the Homepage for this Section? <input name="page_homepage" type="checkbox"/></label>
                            <?php
                        }
                    }
                    else
                    {
                    ?>
                        <br /><label for="homepage">Make this Page the Homepage for this Section? <input name="page_homepage" type="checkbox"/></label>
                    <?php
                    }
                ?>
            </div>
            <?php
                if(strcmp($_GET['mode'],"create") == 0)
                {
            ?>
            <input type="hidden" name="createPage" value="1" />
            <?php
                }
                else if(strcmp($_GET['mode'],"edit") == 0)
                {
            ?>
            <input type="hidden" name="editPage" value="1" />
            <input type="hidden" name="page_id" value="<?php if(isset($page)){echo $page->getPageId();} ?>" />
            <?php
                }
            ?>
            <button type="submit" class="btn btn-success"><?php if(strcmp($_GET['mode'],"create") == 0){ echo "Create Page"; } else { echo "Save Changes";} ?></button>
        </form>
    </div>
</div>

