
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Emotion Detection</title>
    <style>
    .imagetext {
        display: none;
    }
    </style>
</head>

<body>

    <div class="container card mt-5">
        <div class="card-header">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <h1>Emotion Detaction</h1>
        </div>

        <div class="card-body">
            <div class="form-group"><label class="control-label" for="title"><strong>Click On Below Image To Select
                        Image</strong></label>
                <input class="form-control col-lg-8 imagetext" type="file" accept="image/*" name="image" id="image">
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <img src="../images/noimg.png" id="imgsrc" alt="image" srcset="" width="300">
                </div>
                <div class="col-lg-8">
                    <textarea class="col-lg-6" name="text" id="text" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script>
    $('#imgsrc').on('click', function(elm) {
        $('#image').click();
    });

    $('.imagetext').on('change', function() {

        var image = this.files[0];
        var output = document.getElementById('imgsrc');
        output.srcset = URL.createObjectURL(image);

        var token = $('input[name="_token"]').val();

        let formData = new FormData();
        formData.append('file', image);

        formData.append('action', 'expression');

        $.ajax({
            headers: {
                'x-csrf-token': token
            },
            method: 'POST',
            url: '../class/operations.php',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            success: function(resp) {

                // console.log(resp.faceresults);

                var webresult = resp.webresults;
                var faceresult = resp.faceresults;
                var labelresult = resp.labelresults;
                var textresult = resp.textresults;

                var Details = '';

                if (faceresult) {
                    for (let i = 0; i < faceresult.length; i++) {

                        const facerecognization = 'Confidence Percentage: ' + (faceresult[i]
                            .detectionConfidence * 100).toFixed(2) + '%'

                        Details = Details + `Face ${i + 1} \n`;
                        if (webresult) {
                            if (webresult[i].score > 10)
                                Details = Details + 'Name: ' + webresult[i].description + '\n';
                        }

                        for (let j = 0; j < labelresult.length; j++) {
                            if (labelresult[j].description == 'Smile') {
                                const SmileScore = 'Smile Percentage: ' + (labelresult[j].score *
                                    100).toFixed(2) + '%'
                                Details = Details + SmileScore + '\n';
                            }
                            if (labelresult[j].description == 'Happy') {
                                const HappyScore = 'Happy Percentage: ' + (labelresult[j].score *
                                    100).toFixed(2) + '%'
                                Details = Details + HappyScore + '\n';
                            }
                            if (labelresult[j].description == 'Fun') {
                                const FunScore = 'Fun Percentage: ' + (labelresult[j].score * 100)
                                    .toFixed(2) + '%'
                                Details = Details + FunScore + '\n';
                            }
                        }

                        Details = Details + facerecognization + '\n\n';
                    }
                }

                if (textresult) {
                    const textrecognization = textresult[0].description;
                    Details = Details + 'Text Detected:\n' + textrecognization;
                }

                $('#text').text(Details);
            }
        });
    });
    </script>

</body>

</html>