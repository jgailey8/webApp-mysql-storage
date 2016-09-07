<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dangle Project</title>
  <meta content="Dangle Project" name="file storage app for personal use. Built using mysql in php">
  <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity=
  "sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" rel="stylesheet">
  <style type="text/css">
    body
    {
    background:#404040
    }

    .glyphicon.glyphicon-trash 
    {
    font-size: 85%;
    width:100px;
    heigh: 100px;
    width:100%;
    }

    .fileinput-button 
    {
    position: relative;
    overflow: hidden;
    display: inline-block;
    }

    .fileinput-button input 
    {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    opacity: 0;
    -ms-filter: 'alpha(opacity=0)';
    font-size: 200px;
    direction: ltr;
    cursor: pointer;
    }

    .file
    {
    width:100px;height:100px;
    border:1px solid #aaaaaa;
     /*  padding-top: 20px;
    margin-top:20px;
    text-align:center; */
    }
    #deleteZone 
    {
    padding:10px;
    border:1px solid #aaaaaa;
    }
  </style>
</head>
<body>
  <!--

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
-->
  <!-- <link rel="stylesheet" href="css/dropzone.css"> -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
  </script> 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js">
  </script> <!-- <script src="js/dropzone.js"></script> -->
   <!-- javascript/jquery code -->
   
  <script src="js/script.js">
  </script>
  <div class="container" style="background-color:lightgrey;">
    <!-- container for whole page -->
    <?php
         //session is started in header
        //also checks if logged in
        // include 'header.php';
    ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <ul id='uploadList'></ul>
          <form enctype="multipart/form-data" id='uploadForm' method="post" name="uploadForm">
            <div class="row fileupload-buttonbar">
              <div class="col-xs-12" style="padding-top:5px;">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button col-xs-3"><i class="glyphicon glyphicon-plus"></i> <span>Add files...</span> <input id='myFile'
                multiple name="myFile[]" onchange='onFileChange(this)' type="file"></span> <button class="btn btn-primary start col-xs-3 col-xs-offset-1" type=
                "submit"><i class="glyphicon glyphicon-upload"></i> <span>Start upload</span></button> <button class="btn btn-warning cancel col-xs-3 col-xs-offset-1" onclick=
                'cancelUpload(this);' type="reset"><i class="glyphicon glyphicon-ban-circle"></i> <span>Cancel</span></button>
              </div><!-- end of button bar collumn-->
            </div><!-- end of button bar row-->
          </form>
        </div><!-- end of panel body-->
      </div><!-- end of panel -->
      <div class="panel panel-default">
        <div class="panel-body">
            <ol class="breadcrumb" id="folder-path">
            </ol>
          <div id="database">
            <ul class="database list-group" id="database-entries">
              <li class="db-folder" data-path="/tmp" id="db-1"><i class="fa fa-bars db-action" data-target="#context-menu" data-toggle="context" title=
              "Actions"></i> <span><i class="fa fa-folder-open"></i> Folder</span></li>
            </ul>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <span class="btn btn-success col-xs-3 col-xs-offset-2" onclick='downloadFiles();'><i class="glyphicon glyphicon-download">Download</i></span>
            <span class="btn btn-danger col-xs-3 col-xs-offset-2" onclick='deleteFiles();' ondragover="allowDrop(event)" ondrop="drop_delete(event)"><i class=
            "glyphicon glyphicon-trash">Delete</i></span>
          </div>
        </div>
      </div><!-- end of panel-->
  </div> <!-- end of page container -->
</body>
</html>