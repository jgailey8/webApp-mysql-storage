/*
 * TODO:
 *      address issues with foldername,filename naming conflicts
 *      fix some poorly implemented(although it works) code
 *
 */

$(document).ready(function() {
    //this seems to fix that issue with selecting buttons
    $(".btn").click(function(event) {
        $(this).blur(); // Removes focus of the button.
    });

    //show home directory on page load
    fetchDirectory();

    $('#database-entries').on('dblclick', "li.db-folder", function ()
    {
        fetchDirectory($(this).attr('data-FolderName'));
    });
    $('#database-entries').on('click', 'li', function ()
    {
        //allow selecting muiltiple files
        if (window.event.ctrlKey)
        {
        //ctrl was held down during the click
            $(this).addClass("active");
        }
        else
        {
            // console.log('clicked on file');
            //highlight selected course
            $("#database li").removeClass("active");
            $(this).addClass("active");
        }
    });

    //upload files
    /* look into adding some type of progress bar? or could use some library*/
    $('#uploadForm').on('submit', function(e)
    {
        // console.log('uploading file into folder ');
        $currentFolder = $("#folder-path li").last().text();
        //store files info in formdata to pass info in ajax request
        var form = $(this);
        var formData = new FormData($(this)[0]);
        console.log($currentFolder);
        formData.append("Folder", $currentFolder);
         console.log(formData);
        $.ajax(
        {
            url: "upload.php",
            type: "POST",
            dataType: 'json',
            data: formData,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            success: function(data)
            {
                 console.log(data);
                //document.getElementById("message").innerHTML = "";
                $('#uploadList').empty();
                document.getElementById("uploadForm").reset();
                fetchDirectory($currentFolder);
            },
            error: function(error)
            {
                 console.log(error);
            }
        }); //end of ajax call

        e.preventDefault(); // avoid to execute the actual submit of the form.

    }); //end of upload Submit

});

//fetch and display current directory
//not the most elegant implementation
function fetchDirectory(directory="Jared") {
    if(directory != "Jared")
    {
          $("#folder-path").append("<li>"+directory+"</li>");
    }
    // console.log("getting files from folder "+directory);
        $('#database-entries').empty();
        $("#folder-path").empty();
    $.ajax({
        url: "DB.php",
        type: "POST",
        dataType: 'json',
        data: {"folderName":directory}, 
        success: function(data) {
            // console.log(data);
            //not the most elegant implementation but simple

            $.each(data.Folders, function(key, value) {
                $row = "<li class='db-folder list-group-item'>";
                $row += "<i class='fa fa-bars db-action' title='Actions' data-toggle='context' data-target='#context-menu'></i>";
                $row += "<span> <i class='fa fa-folder-open'></i>" + value.FolderName + "</span></li>";
                $("#database-entries").append($row);
                $("#database-entries li").last().attr('data-FolderName', value.FolderName);
            });
            $.each(data.Files, function(key, value) {
                $row = "<li class='db-file list-group-item'>";
                $row += "<i class='fa fa-bars db-action' title='Actions' data-toggle='context' data-target='#context-menu'></i>";
                $row += "<span> <i class='fa fa-file'></i> " + value.FileName + "</span></li>";
                $("#database-entries").append($row);
                $("#database-entries li").last().attr('data-FileName', value.FileName);
                $("#database-entries li").last().attr('data-FileDate', value.FileDate);
                $("#database-entries li").last().attr('data-FileSize', fileSize(value.FileType));
            });
            //bind doublcick function to directory path
            $.each(data.Path.reverse(), function(key, value)
            {
                $("#folder-path").append("<li onDblClick=fetchDirectory('"+value+"') >"+value+"</li>");
            });
        },
        error: function(error) {
            console.log(error);
        }
    }); //end of ajax call
}

//delete files from database, allow muitiple deletions at once?
//should prolly use confirmation dialog or something
function deleteFiles()
{
    var selectedFiles=[]; //files to be deleted
    var selectedFolders=[]; //folders to be deleted

    var curFolder = $("#folder-path li").last().text();
    // console.log("deleting files from folder: "+curFolder);
    //get the selected files to be deleted
    //  FIX: inneficient to loop through the entire list of entries
    $('#database-entries li.active').each(function(index,selected)
    {
        // console.log($(this).attr('data-FileName'));
        if($(this).hasClass('db-file'))
        {
            selectedFiles.push($(this).attr('data-FileName'));
            //also need to include current folder aka parent folder
            //
        }
        if($(this).hasClass('db-folder'))
        {
            selectedFolders.push($(this).attr('data-folderName'));
        }
    });
    // console.log(selectedFiles);
    // console.log(selectedFolders);
    
        $.ajax(
        {
            url: "deleteFile.php",
            type: "GET",
            // dataType: 'json',
            data: {"FileList[]":selectedFiles, "CurrentFolder":curFolder },
            
            success: function(data)
            {
                // console.log(data);
                fetchDirectory(curFolder);   
            },
            error: function(error)
            {
                 console.log(error);
            }
        }); //end of ajax call
}

//display files to be uploaded when they are added to form
function onFileChange(selected)
{
     $('#uploadList').empty();
    var files = $("#myFile")[0].files;

    for (var i = 0, f; file = files[i]; i++)
    {
        //console.log(file);
        // console.log(file.name);
        $row  = "<li class='list-group-item'> \
                " + file.name+"     "+ file.size + ":bytes</li>";
        $("#uploadList").append($row);
    }
}

//convert file size from bytes to something a little easier to read
function fileSize(bytes) {
    var exp = Math.log(bytes) / Math.log(1024) | 0;
    var result = (bytes / Math.pow(1024, exp)).toFixed(2);

    return result + ' ' + (exp == 0 ? 'bytes': 'KMGTPEZY'[exp - 1] + 'B');
}
