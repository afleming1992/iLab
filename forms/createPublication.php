<script type="text/javascript">
    function getContentFromPure()
    {
        var uuidUrl = $("#pure_uuid").val();
        var start_pos = uuidUrl.indexOf('(') + 1;
        var end_pos = uuidUrl.indexOf(')',start_pos);
        var uuid = uuidUrl.substring(start_pos,end_pos)
        if(uuid.length > 0)
        {
            $.ajax({
                type: "GET",
                url: "ajax/getPublicationFromPure.php?uuid=" + uuid,
                dataType: "xml",
                success: xmlParser
            });
            return true;
        }
        else
        {
            $("#pure_box").append("<h3>Error</h3><p>We couldn't get that Data for some reason</p>");
        }
    }

    function xmlParser(xml)
    {
        var title = $(xml).find("publication-base_uk\\:title, title");
        if(title.length > 0)
        {
            var abstract = $(xml).find("publication-base_uk\\:abstract, abstract");
            var abstractText = $(abstract).find("core\\:localizedString, localizedString");
            var publicationYear = $(xml).find("core\\:year, year");
            var publishedIn = $(xml).find("publication-base_uk\\:hostPublicationTitle, hostPublicationTitle");
            var publisher = $(xml).find("publisher-template\\:name, name");
            var downloadLink = $(xml).find("core\\:doi, doi").eq(0);
            downloadLink = $(downloadLink).find("core\\:doi, doi").eq(0);
            var downloadText = downloadLink.text();

            $('#publication_title').val(title.text());
            $('#publication_abstract').val(abstractText.text());
            $('#publication_year').val(publicationYear.text());
            $('#publication_publisher').val(publisher.text());
            $('#publication_publishedIn').val(publishedIn.text());
            $('#pure_box').addClass("hidden");
            $('#choice_box').addClass("hidden");
            $('#form_box').removeClass("hidden");
            if(downloadText.length > 0)
            {
                $('#publication_link').val(downloadText);
                $('#file_choice').filter('[value=link]').prop('checked',true);

                //Change the Radio Checked Value
                var $radios = $('input:radio[name=file_choice]');
                $radios.filter('[value=link]').attr('checked', true);
                hideFileLink();
                showLink();
            }
            return true;
        }
        else
        {
            $('#pure_errorMessage').html("No Content Available");
        }
    }

    function displayPureBox()
    {
        $("#pure_box").removeClass("hidden");
    }

    function hidePureBox()
    {
        $("#pure_box").addClass("hidden");
    }

    function moveToForm()
    {
        $("#choice_box").addClass("hidden");
        $("#form_box").removeClass("hidden");
        $("#pure_box").addClass("hidden");
    }

    function showFile()
    {
        $("#file_box").removeClass("hidden");
    }

    function showLink()
    {
        $("#link_box").removeClass("hidden");
    }

    function hideFileLink()
    {
        $("#file_box").addClass("hidden");
        $("#link_box").addClass("hidden");
    }

    function validateForm()
    {

    }
</script>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Create a New Publication</h3>
    </div>
    <div class="panel-body">
            <div id="choice_box" class="well">
                <p>
                     This application can load content from the Heriot-Watt University Research Gateway (or PURE as it's known internally).
                </p>
                <p>
                    Do you wish to pull information from PURE or create a new publication from scratch?
                    <br />
                    <a class="btn btn-success btn-block" onClick="return displayPureBox();">Pull Content from Pure</a><a class="btn btn-danger btn-block" onClick="return moveToForm()">Start from Scratch</a>
                </p>
            </div>
            <div id="pure_box" class="well hidden">
                <p>Please go to the Publication on the Research Gateway and copy and paste the URL into the box below</p>
                <p></p>
                    <form>
                        <div id="pure_errorMessage" class="alert alert-danger hidden">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Please put the URL in this Box</label>
                            <input type="text" class="form-control" id="pure_uuid" placeholder="http://">
                        </div>
                        <a id="getContentButton" class="btn btn-info" onClick="return getContentFromPure()" id="pureGetButton"><span class="glyphicon glyphicon-cloud-download"></span> Get Content</a>
                    </form>
            </div>
            <div id="form_box" class="well hidden">
                <form method="post" enctype="multipart/form-data" action="index.php">
                <div class="form-group">
                    <label for="publication_title">Title</label>
                    <input type="text" class="form-control" id="publication_title" name="publication_title" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="publication_publishedIn">Published In</label>
                    <input type="text" class="form-control" id="publication_publishedIn" name="publication_publishedIn"/>
                </div>
                <div class="form-group">
                    <label for="publication_publisher">Publication Organisation</label>
                    <input type="text" class="form-control" id="publication_publisher" name="publication_publisher"/>
                </div>
                <div class="form-group">
                    <label for="publication_year">Year</label>
                    <input type="text" class="form-control" id="publication_year" name="publication_year" placeholder="yyyy" />
                </div>
                <div class="form-group">
                    <label for="publication_abstract">Abstract</label>
                    <textarea class="form-control" id="publication_abstract" name="publication_abstract" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <h3>File Upload/Link</h3>
                    <div class="radio">
                        <label>
                            <input type="radio" name="file_choice" id="file_choice_file" value="none" onClick="hideFileLink();" checked>
                            I don't have a Link or File
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="file_choice" id="file_choice_link" value="file" onClick="hideFileLink();showFile();">
                            Upload a File
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="file_choice" id="file_choice" value="link" onClick="hideFileLink();showLink();">
                            Provide a Link to the Publication
                        </label>
                    </div>
                </div>
                <div id="file_box" class="form-group hidden">
                    <label for="publication_file">Select the File you wish to upload <em>PDF's Only!</em></label>
                    <input type="file" class="form-control" name="publication_file" id="publication_file" />
                </div>
                <div id="link_box" class="form-group hidden">
                    <label for="">Link to Publication</label>
                    <input type="text" class="form-control" name="publication_link" id="publication_link" />
                </div>
                <input type="hidden" name="createPublication" value="1" />
                <button type="submit" id='submitButton' class="btn btn-success"><span class="glyphicon glyphicon-floppy-saved"></span> Create Publication</button>
            </div>
        </form>
    </div>
</div>

