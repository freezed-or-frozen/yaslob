/**
 * YASLOB : Yet Another Simple Library Of eBooks
 * Custom Javascript for the Views (V of MVC)
 * 
 * @author David SALLÉ
 * @date April 2021
 * @license MIT
 */

// URL vers le fichier PDF à téléverser
let url_fichier = "";

// Octets du fichier PDF à téléverser
let pdf_octets = null;


/**
 * Get cover image and informations (title, author, pages...) from PDF
 * @param {*} fichier 
 */
function getCoverAndInformations(fileToUpload) {
    url_fichier = URL.createObjectURL(fileToUpload);
    let loadingPdf = pdfjsLib.getDocument({ url: URL.createObjectURL(fileToUpload) });    
    loadingPdf.promise.then(function(pdf) {
        console.log("PDF loaded");

        // Get number of pages
        let total_pages = pdf.numPages;
        console.log("total_pages => " + total_pages);
        document.getElementById("pages").value = pdf.numPages;

        // Get metadatas : title, author and year
        pdf.getMetadata().then(function(metadata) {
            console.log("Metadata loaded");
            console.log(metadata.info);
            if (metadata.info.Title) {
                document.getElementById("title").value = metadata.info.Title;
            }
            if (metadata.info.Author) {
                document.getElementById("author").value = metadata.info.Author;
            }
            if (metadata.info.CreationDate) {
                document.getElementById("year").value = metadata.info.CreationDate.substring(2, 6);
            }
        })        

        // Get cover image
        pdf.getPage(1).then(function(page) {
            console.log("Cover loaded");

            let viewport = page.getViewport({scale: 0.5});
            let canvas = $("#pdf-canvas")[0];
            let context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            let renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            let renderTask = page.render(renderContext);
            renderTask.promise.then(function () {
                console.log('Page rendered');
            });
        })
    });
}


/**
 * Upload an ebook thru JSON and base64 encoding
 */
function uploadEbook() {
    // Prepare JSON data to be sent
    let jsonData = {};
    jsonData["title"] = document.getElementById("title").value;
    jsonData["author"] = document.getElementById("author").value;
    jsonData["pages"] = document.getElementById("pages").value;
    jsonData["year"] = document.getElementById("year").value;
    jsonData["description"] = document.getElementById("description").value;
    jsonData["tags"] = document.getElementById("tags").value;
    jsonData["cover"] = document.getElementById("pdf-canvas").toDataURL();

    // Load PDF file to encode it in base64
    let file_to_upload = document.getElementById("file-to-upload").files[0];
    console.log("file_to_upload => " + file_to_upload);
    let fileReader = new FileReader();  
    fileReader.onload = function(fileLoadedEvent) {
        //pdf_octets = new Uint8Array(this.result);  
        console.log("PDF file is loaded")
        let base64 = fileLoadedEvent.target.result;
        jsonData["pdf"] = base64;
        //console.log(jsonData);
        //console.log(base64);

        // Send data
        $.ajax({
            url: "http://127.0.0.1/yaslob/index.php?action=upload",
            type: "POST",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: JSON.stringify(jsonData),
            success: function (response) {
                console.log("Server response (success) => " + response);

                // Redirection
                window.location.href = "http://127.0.0.1/yaslob/index.php?action=list";
            },
            error: function(xhr, status, errorThrown){
                console.log("Server response (error) => " + xhr.responseText);
                console.log("Server response (error) => " + status);
                console.log("Server response (error) => " + errorThrown);
            }     
        });
    }
    //console.log("AVANT => " + jsonData);
    fileReader.readAsDataURL(file_to_upload);
}


/**
 * When selecting a PDF to upload...
 */
$("#file-to-upload").on('change', function(event) {
    console.log("file-to-upload => clicked");

    let fileToUpload = event.target.files[0];
    console.log("fileToUpload.type => " + fileToUpload.type);
    getCoverAndInformations(fileToUpload);
});


/**
 * When clicking on the [Upload ebook] button
 */
$("#jsonupload").on('click', function(event) {
    console.log("jsonupload button clicked");

    //let fichier = event.target.files[0];
    uploadEbook();
});




