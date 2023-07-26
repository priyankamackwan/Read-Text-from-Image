<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Text Detection</title>
    <style>
        .imagetext {
            display:none;
        }
    </style>
  </head>
  <body>

    <div class="container card mt-5">
        <div class="card-header">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <h1>Text Detaction</h1>
        </div>

        <div class="card-body">
            <div class="form-group"><label class="control-label" for="title"><strong>Click On Below Image To Select Image</strong></label>
                <input class="form-control col-lg-8 imagetext" type="file" accept="image/*" name="image" id="image">
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <img src="../images/noimg.png" id="imgsrc" alt="image" srcset="" width="300">
                </div>
                <div class="col-lg-8">
                    <textarea class="col-lg-6" name="text" id="text" cols="30" rows="10">Text From Image Are Shown Here.</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>

    $('#imgsrc').on('click', function () {
        $('#image').click();
    })

    $('.imagetext').on('change', function () {

        var image = this.files[0];

        var output = document.getElementById('imgsrc');
        output.srcset = URL.createObjectURL(image);

        var token = $('input[name="_token"]').val();

        let formData = new FormData();
        formData.append("file", image);

        formData.append("action", 'imagetotext');

        $.ajax({
            headers: { 'x-csrf-token': token  },
            method: 'POST',
            url: 'text.php',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                if(data)
                $('#text').text(data);
            }
        });

    });

    </script>

  </body>
</html>