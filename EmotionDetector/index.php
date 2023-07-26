<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Face Recognization</title>

    <style scope="vs-likeliness">
    .progress {
        height: 7px;
    }

    .progress-bar {
        background-color: #81C784;
    }

    .imagetext {
        display: none;
    }

    :host * {
        box-sizing: border-box
    }

    .flexdiv {
        align-items: center;
        display: flex
    }

    .label {
        font-size: 1em;
        padding-right: 9px;
        width: 80px
    }

    .meter {
        background-color: #d3d3d3;
        flex-grow: 1;
        position: relative;
        margin-left: 30px;
    }

    .meter::after {
        background: linear-gradient(90deg,
                rgba(255, 255, 255, 0) 20%,
                rgba(255, 255, 255, 1) 20%,
                rgba(255, 255, 255, 1) 21%,
                rgba(255, 255, 255, 0) 21%,
                rgba(255, 255, 255, 0) 40%,
                rgba(255, 255, 255, 1) 40%,
                rgba(255, 255, 255, 1) 41%,
                rgba(255, 255, 255, 0) 41%,
                rgba(255, 255, 255, 0) 60%,
                rgba(255, 255, 255, 1) 60%,
                rgba(255, 255, 255, 1) 61%,
                rgba(255, 255, 255, 0) 61%,
                rgba(255, 255, 255, 0) 80%,
                rgba(255, 255, 255, 1) 80%,
                rgba(255, 255, 255, 1) 81%,
                rgba(255, 255, 255, 0) 81%);
        bottom: 0;
        content: '';
        display: block;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 1
    }

    .bar {
        height: 15px
    }

    .text {
        font-size: .75em;
        padding-left: 12px;
        width: 100px
    }

    .type-row {
        margin: 20px;
    }

    .anyClass {
        height: 245px;
        overflow-y: scroll;
        display: none;
    }

    .active {
        display: block;
    }

    .facenumber {
        margin: 20px;
    }
    </style>

</head>

<body>

    <div class="container card mt-5">

        <div align="center" class="card-header">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <h1>Face Recognization</h1>

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item m-3" role="presentation">
                    <button class="navclass nav-link btn active faces">Faces</button>
                </li>
                <li class="nav-item m-3" role="presentation">
                    <button class="navclass nav-link btn objects">Objects</button>
                </li>
                <li class="nav-item m-3" role="presentation">
                    <button class="navclass nav-link btn labels">Labels</button>
                </li>
                <li class="nav-item m-3" role="presentation">
                    <button class="navclass nav-link btn safesearch">Safe Search</button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-faces" role="tabpanel"
                    aria-labelledby="pills-faces-tab">
                    <div class="form-group"><label class="control-label" for="title">
                            <strong>Click On Below Image To Select Image</strong></label>
                        <input class="form-control col-lg-8 imagetext" type="file" accept="image/*" name="image"
                            id="image">
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <img src="../images/noimg.png" id="imgsrc" alt="image" srcset=""
                                style="max-height:550px;max-width:450px;">
                        </div>

                        <div class="clonefaces col-lg-8 rounded border anyClass active faces">
                            <div class="facenumberdiv1">
                                <h2 class="facenumber" style="display:none;">Face 1</h2>
                                <div class="type-row flexdiv joyLikelihood">
                                    <div class="label">Joy</div>
                                    <div class="meter">
                                        <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                    </div>
                                    <div class="text">Unknown</div>
                                </div>
                                <div class="type-row flexdiv sorrowLikelihood">
                                    <div class="label">Sorrow</div>
                                    <div class="meter">
                                        <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                    </div>
                                    <div class="text">Unknown</div>
                                </div>
                                <div class="type-row flexdiv angerLikelihood">
                                    <div class="label">Anger</div>
                                    <div class="meter">
                                        <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                    </div>
                                    <div class="text">Unknown</div>
                                </div>
                                <div class="type-row flexdiv surpriseLikelihood">
                                    <div class="label">Surprise</div>
                                    <div class="meter">
                                        <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                    </div>
                                    <div class="text">Unknown</div>
                                </div>
                                <div class="type-row flexdiv underExposedLikelihood">
                                    <div class="label">Exposed</div>
                                    <div class="meter">
                                        <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                    </div>
                                    <div class="text">Unknown</div>
                                </div>
                                <div class="type-row flexdiv blurredLikelihood">
                                    <div class="label">Blurred</div>
                                    <div class="meter">
                                        <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                    </div>
                                    <div class="text">Unknown</div>
                                </div>
                                <div class="type-row flexdiv headwearLikelihood">
                                    <div class="label">Headwear</div>
                                    <div class="meter">
                                        <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                    </div>
                                    <div class="text">Unknown</div>
                                </div>
                                <div class="form-group type-row">
                                    <div style="text-align:left;" class="name">Confidence
                                        <span class="confidence-level" style="float:right;">0%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 rounded border anyClass objects">
                            No Objects Found!
                        </div>

                        <div class="col-lg-8 rounded border anyClass labels">
                            No Labels Found!
                        </div>


                        <div class="col-lg-8 rounded border anyClass safesearch">
                            <div class="type-row flexdiv adult">
                                <div class="label">Adult</div>
                                <div class="meter">
                                    <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                </div>
                                <div class="text">Unknown</div>
                            </div>
                            <div class="type-row flexdiv spoof">
                                <div class="label">Spoof</div>
                                <div class="meter">
                                    <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                </div>
                                <div class="text">Unknown</div>
                            </div>
                            <div class="type-row flexdiv medical">
                                <div class="label">Medical</div>
                                <div class="meter">
                                    <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                </div>
                                <div class="text">Unknown</div>
                            </div>
                            <div class="type-row flexdiv violence">
                                <div class="label">Violence</div>
                                <div class="meter">
                                    <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                </div>
                                <div class="text">Unknown</div>
                            </div>
                            <div class="type-row flexdiv racy">
                                <div class="label">Racy</div>
                                <div class="meter">
                                    <div class="bar" style="background-color:#81C784;width:0%;"></div>
                                </div>
                                <div class="text">Unknown</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="../js/app.js"></script>
</body>

</html>