$(".navclass").click(function () {
    $(".navclass").removeClass("active");
    $(".anyClass").removeClass("active");
    var lastClass = $(this).attr('class').split(' ').pop();
    $('.' + lastClass).addClass("active");
});

$('#imgsrc').on('click', function (elm) {
    $('#image').click();
});

$('.imagetext').on('change', function () {

    var image = this.files[0];
    var output = document.getElementById('imgsrc');
    output.srcset = URL.createObjectURL(image);
    output.width = '250';

    var token = $('input[name="_token"]').val();

    let formData = new FormData();
    formData.append('file', image);

    // formData.append('action', 'expression');

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
        success: function (resp) {

            var webresult = resp.webresults,
             faceresult = resp.faceresults,
             labelresult = resp.labelresults,
             textresult = resp.textresults,
             safeSearchresult = resp.safeSearchresults,
             objectresult = resp.localizeObjectResults;
           
            var cloneCount = 2, classKey = 1, labels = '', objects = '';

            if (faceresult) {
                $('.removediv').remove();
                $(faceresult).each(function (key, val) {


                    $('.facenumber').css('display', 'none');
                    if (key !== 0) {
                        $('.facenumber').css('display', 'block');

                        var clone = $('.facenumberdiv1')
                            .clone()
                            .attr('class', 'removediv facenumberdiv' + cloneCount);
                            
                            $('.clonefaces').append(clone);
                            $(`.facenumberdiv${cloneCount} .facenumber`).text(`Face ${cloneCount++}`);
                    }

                    for (var emotion in val) {

                        var emotionValue = val[emotion];
                        var emotionClass = `.facenumberdiv${classKey} .${emotion}`;
                        let percentage = (val['detectionConfidence'] * 100).toFixed(2)+'%';
                        $(`.facenumberdiv${classKey} .confidence-level`).text(`${percentage}`);
                        $(`.facenumberdiv${classKey} .progress-bar`).css('width',percentage);
                        
                        switch (emotionValue) {
                            case 'VERY_LIKELY':
                                $(`${emotionClass} .bar`).css('width', '100%');
                                $(`${emotionClass} .text`).text('VERY_LIKELY');
                                break;
                            case 'LIKELY':
                                $(`${emotionClass} .bar`).css('width', '80%');
                                $(`${emotionClass} .text`).text('LIKELY');
                                break;
                            case 'POSSIBLE':
                                $(`${emotionClass} .bar`).css('width', '60%');
                                $(`${emotionClass} .text`).text('POSSIBLE');
                                break;
                            case 'UNLIKELY':
                                $(`${emotionClass} .bar`).css('width', '40%');
                                $(`${emotionClass} .text`).text('UNLIKELY');
                                break;
                            case 'VERY_UNLIKELY':
                                $(`${emotionClass} .bar`).css('width', '20%');
                                $(`${emotionClass} .text`).text('VERY_UNLIKELY');
                                break;
                            default:
                                $(`${emotionClass} .bar`).css('width', '0%');
                                $(`.${emotion} .text`).text('UNKNOWN');
                        }
                    }
                    classKey++;
                });
            }

            if (labelresult) {
                $(labelresult).each(function (key, val) {

                    let percentage = (val.score * 100).toFixed(2)+'%';

                    labels += `<div class="form-group type-row">`+
                        `<div style="text-align:left;" class="name">${val.description} <span style="float:right;">${percentage}</span></div>`+
                        `<div class="progress">`+
                        `<div class="progress-bar" style="width:${percentage}" role="progressbar"></div>`+
                        `</div>`+
                    `</div>`
                });
                $('div.labels').empty();
                $('div.labels').append(labels);
            }
            
            if (objectresult) {
                $(objectresult).each(function (key, val) {

                    let percentage = (val.score * 100).toFixed(2)+'%';

                    objects += `<div class="form-group type-row">`+
                        `<div style="text-align:left;" class="name">${val.name} <span style="float:right;">${percentage}</span></div>`+
                        `<div class="progress">`+
                        `<div class="progress-bar" style="width:${percentage}" role="progressbar"></div>`+
                        `</div>`+
                    `</div>`
                });
                $('div.objects').empty();
                $('div.objects').append(objects);
            }

            if (safeSearchresult) {
                for (var search in safeSearchresult) {

                    var searchValue = safeSearchresult[search];
                    
                    switch (searchValue) {
                        case 'VERY_LIKELY':
                            $(`div.safesearch .${search} .bar`).css('width', '100%');
                            $(`div.safesearch .${search} .text`).text('VERY_LIKELY');
                            break;
                        case 'LIKELY':
                            $(`div.safesearch .${search} .bar`).css('width', '80%');
                            $(`div.safesearch .${search} .text`).text('LIKELY');
                            break;
                        case 'POSSIBLE':
                            $(`div.safesearch .${search} .bar`).css('width', '60%');
                            $(`div.safesearch .${search} .text`).text('POSSIBLE');
                            break;
                        case 'UNLIKELY':
                            $(`div.safesearch .${search} .bar`).css('width', '40%');
                            $(`div.safesearch .${search} .text`).text('UNLIKELY');
                            break;
                        case 'VERY_UNLIKELY':
                            $(`div.safesearch .${search} .bar`).css('width', '20%');
                            $(`div.safesearch .${search} .text`).text('VERY_UNLIKELY');
                            break;
                        default:
                            $(`div.safesearch .${search} .bar`).css('width', '0%');
                            $(`div.safesearch .${search} .text`).text('UNKNOWN');
                    }
                }
            }
        }
    });
});