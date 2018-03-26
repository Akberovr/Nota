/**
 * Created by Hp on 3/25/2018.
 */


Dropzone.options.uploads = {


    maxFileSize: 2,
    acceptedFiles: ".png, .jpg, .jpeg",
    success:function (file,response) {

        if(file.status === "success"){

               handleResponse.handleSuccess(response);

        } else{

                handleResponse.handleError(response);
        }

    }


};

var handleResponse = {


    handleError: function (response) {
        var msg =  document.getElementById("msg");
        msg.innerHTML = "Only png,jpeg,jpg allowed";
    },

    handleSuccess: function (response) {
        var msg =  document.getElementById("msg");
        msg.innerHTML = "Uploaded succesfully";
    }

};