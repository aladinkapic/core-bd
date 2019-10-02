$("document").ready(function(){
    $("#files").change(function() {
        var formData = new FormData();
        formData.append('file', $('#files')[0].files[0]);          // Append file to data
        formData.append('model', $(this).attr('model'));           // Append model name to data
        formData.append('path', $(this).attr('path'));             // Append path where to save data

        //console.log(formData.get('file')['name']);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let id = Date.now();

        let elem = $("#all-uploaded-files-at-once").append(
            '<div class="single-saved-file">' +
            '<div class="single-saved-file-image">'+
            '<i class="fas fa-images"></i>' +
            '</div>' +
            '<div class="single-saved-file-details">' +
            '<div class="single-saved-file-details-name">' +
            '<p>' + formData.get('file')['name'] + '</p>' +
            '</div>' +
            '<div class="single-saved-file-details-progress">'+
            '<div class="single-progress-element" id="progress'+ id +'"></div>' +
            '</div>' +
            '<div class="single-saved-file-details-percentage">' +
            '<p id="'+ id +'">0%</p>' +
            '</div>' +
            '</div>' +
            '</div>'
        );

        $.ajax({
            url : $(this).attr('url'),
            type : 'POST',
            data : formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType

            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#" + id).html(percentComplete + "%");
                        $("#progress" + id).css('width', percentComplete + '%');
                        // console.log(percentComplete);
                    }
                }, false);
                return xhr;
            },
            success : function(data) {
                console.log(data['success']);
                if(data['success']){
                    let elem = $("#all-uploaded-files-at-once").append(
                        '<input type="hidden" name="_uploaded_files[]" value="'+ data['success'] +'">'
                    );
                }
            }
        });
    });
})