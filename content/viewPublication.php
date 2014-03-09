<div class="row col-md-14">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">
                    Navigation
                </h1>
            </div>
            <div class="panel-body" style="padding:0">
                <?php
                    echo $sideNav;
                ?>
            </div>
        </div>
        <?php
            if($admin || $_SESSION['access_level'] > 1)
            {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title">
                            Administration
                        </h1>
                    </div>
                    <div class="panel-body" style="padding:0">
                        <?php
                            echo $adminSection;
                        ?>
                    </div>
                </div>
            <?php
            }
        ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $publication->getName(); ?></h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well" style="min-height:100%">
                            <h4>Year - <?php echo $publication->getYear() ?></h4>
                            <?php
                                if(strlen($publication->getPublishedIn()) > 0)
                                {
                                    ?>
                                        <p>Published In <?php echo $publication->getPublishedIn(); ?></p>
                            <?php
                                }

                                if(strlen($publication->getPublisher()) > 0)
                                {
                                ?>
                            <p><em>Publisher</em> <br /><?php echo $publication->getPublisher(); ?></p>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="well">
                            <?php
                                $authors = $publication->getAuthors();
                                $ilabAuthors = "";
                                $nonAuthors = "";
                                foreach($authors as $author)
                                {
                                    if(!is_string($author))
                                    {
                                        $ilabAuthors .= $author->getProfile()->generateProfileLink();
                                    }
                                    else
                                    {
                                        if(strlen($nonAuthors) > 0)
                                        {
                                            $nonAuthors .= ", ".$author;
                                        }
                                        else
                                        {
                                            $nonAuthors = $author;
                                        }
                                    }
                                }
                                echo $ilabAuthors;
                                ?>
                                    <h5>Other Authors</h5>
                                <?php
                                echo $nonAuthors;
                            ?>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $(".profile").tooltip({
                                        'html': true
                                    })
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if(strlen($publication->getAbstract()) > 0)
                            {
                                ?>
                                    <div class="well">
                                        <?php echo $publication->getAbstract(); ?>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                            if(strlen($publication->getLink()) > 0)
                            {
                                ?>
                                    <div class="well">
                                        <a class="btn btn-block btn-primary" href="<?php echo $publication->getLink() ?>">Download Publication</a>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete this Publication</h4>
            </div>
            <div class="modal-body">
                <h3>Are you sure you wish to delete this Publication?</h3>
                <br/><br />
                <a href='?mode=delete&type=publication&id=<?php echo $publication->getId(); ?>' class="btn btn-block btn-success">Yes</a><a href='' data-dismiss='modal' class="btn btn-block btn-danger">No</a>
            </div>
        </div>
    </div>
</div>

