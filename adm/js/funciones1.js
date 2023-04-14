$(document).ready(function () {
    // FORMATO DE NOMBRE
    $(document).on("keydown keyup", ".format-string", function (e) {
        tecla = e.keyCode || e.which;
        if ((tecla < 65 || tecla > 90) && tecla != 8 && tecla != 9 && (tecla < 37 && tecla > 40) && (tecla != 86 && tecla != 17) && (tecla != 67 && tecla != 17) && tecla != 20 && tecla != 32 && tecla != 35 && tecla != 36 && tecla != 116 && tecla != 188 && tecla != 190 && tecla != 192){
            e.preventDefault();
        }
        $(this).val($(this).val().replace(/\d/g,''));
    });
    // FORMATO PARA NUMEROS
    $(document).on("keydown keyup", ".format-number", function (e) {
        tecla = e.keyCode || e.which;
        if (((tecla < 48 || tecla > 57) && (tecla < 96 || tecla > 105) && (tecla != 86 && tecla != 17) && (tecla != 88 && tecla != 17) && (tecla != 67 && tecla != 17)) && tecla != 8 && tecla != 9 && tecla != 116 && tecla != 35 && tecla != 36){
            e.preventDefault();
        }
        $(this).val($(this).val().replace(/[a-zA-Z]/g,''));
    });
    // FORMATO PARA PRECIOS
    $(document).on("keydown keyup", ".format-price", function (e) {
        tecla = e.keyCode || e.which;
        if (((tecla < 48 || tecla > 57) && (tecla < 96 || tecla > 105) && (tecla != 86 && tecla != 17) && (tecla != 88 && tecla != 17) && (tecla != 67 && tecla != 17)) && tecla != 8 && tecla != 9 && tecla != 116 && tecla != 35 && tecla != 36){
            e.preventDefault();
        }
        $(this).val($(this).val().replace(/[a-zA-Z]/g,''));
    });
    // EXPANDIR - CONTRAER MAPA
    $(document).on("click", "#expandir_mapa", function () {
        var mapa = $(this).data("map");
        $(mapa).slideToggle();
    });
    // DROPDOWN FIXED
    $(document).on("show.bs.dropdown", "td", function () {
        $(this).css("z-index", '1');
    });
    $(document).on("hidden.bs.dropdown", "td", function () {
        $(this).css("z-index", '0');
    });
    // DROPDOWN FILTER
    $(document).on("click", ".item-filter", function () {
        var id = $(this).data("id");
        var texto = $(this).data("texto");
        $(this).parent().prev().text(texto).data("id", id);
    });
    // LIMIT CHAR
    $(document).on("keyup keydown","[maxlength]",function(){
        var max=$(this).attr("maxlength");
        if($(this).hasClass("format-number")){
            max-=10;
        }
        var length_value=$(this).val().length;
        $(this).siblings(".limit-char").text(`(${length_value}/${max})`);
    });
    // OCULTAR / MOSTRAR COLUMNAS DE TABLA
    $(document).on("click","#toggle_columnas",function(){
        var tabla=$(this).data("tabla");
        var index=$(this).data("index");
        var column = eval(tabla+'.column('+index+')');
        column.visible(!column.visible());
        if($(this).data("boolean")==1){
            $(this).data("boolean",0).find("svg").remove();
            var texto=$(this).text();
            $(this).html("<i class='fa-solid fa-eye-slash me-2 align-middle'></i>"+texto);
        }
        else{
            $(this).data("boolean",1).find("svg").remove();
            var texto=$(this).text();
            $(this).html("<i class='fa-solid fa-eye me-2 align-middle'></i>"+texto);   
        }
    });
    $(document).on("click","[data-modal]",function(){
        var modal=$(this).data("modal");
        $(modal).modal("show");
    });
    // WIZARDS
    $(document).on("click","[data-tab]",function(){
        var tab=$(this).data('tab');
        var id=tab.replace("#","");
        $("a[href='"+tab+"']").parent().siblings("li").find("a").removeClass("active").attr("aria-selected","false");
        $("a[href='"+tab+"']").addClass("active").attr("aria-selected","true");
        $("#tab_contenedor div[role='tabpanel']").removeClass("active");
        $("#tab_contenedor div[id='"+id+"']").addClass("active");
    });
    /* -------------------------------- EDICIONES ------------------------------- */
    // MODIFICAR
    $(document).on("click", "[data-table]", function () {
        var type = $(this).data("type");
        var tabla = $(this).data("table");

        if (type == "update") {
            var table = $("#" + tabla).DataTable();
            var total_td = table.row($(this).parent().parent().parent().parent()).data().length - 1;
            var td = table.row($(this).parent().parent().parent().parent()).data();
            for (var i = 0; i < total_td; i++) {
                var node = $("#modal-update").find('.child').eq((i)).prop("nodeName");
                if (node == "SELECT") {
                    var id_select = $("#modal-update").find('.child').eq((i)).attr("id");
                    var value_option = $("#" + id_select).find('option[text="' + td[i] + '"]').attr('value');
                    var slim_select = eval("select_" + id_select);
                    slim_select.set(value_option);
                }
                else {
                    $("#modal-update").find('.child').eq((i)).val(td[i]);
                }
            }
            $("#modal-update button.edit").data("id", $(this).data("id"));
            limite_caracteres(2);
            $("#modal-update").modal("show");
        }
        else if (type = "delete") {
            $("#modal-delete button.delete").data("id", $(this).data("id"));
            $("#modal-delete").modal("show");
        }
    });
});
// FUNCIONES
function get_view_main(pathname, file, data, selector_main, limit_char=1) {
    $.ajax({
        type: "POST",
        url: "../php/v/1/" + pathname + "/" + file + ".php",
        data: data,
        beforeSend: function () {
            loader(selector_main);
        },
        success: function (response) {
            $(selector_main).html(response);
        },
        complete: function () {
            $(selector_main).removeClass("disabledevent");
            $("#loader").remove();
            limite_caracteres(limit_char);
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                show_message('Error.', 'Conéctate a una red', 'error', 3000);
            } else if (jqXHR.status == 404) {
                show_message('Error ' + jqXHR.status, 'solicitud no encontrada', 'error', 3000);
            } else if (jqXHR.status == 500) {
                show_message('Error ' + jqXHR.status, 'error interno del servidor', 'error', 3000);
            } else if (exception === 'timeout') {
                show_message('Error.', 'ha excedido el límite de tiempo', 'error', 3000);
            } else {
                show_message('Error', 'Conéctate a una red', 'error', 3000);
            }
        },
    });
}
function add_row(dirname, file, data, selector, target) {
    var text = $(target).html();
    $.ajax({
        type: "POST",
        url: "../php/c/1/" + dirname + "/" + file + ".php",
        data: data,
        beforeSend: function () {
            $(target).attr("disabled", true).html("Espere...");
        },
        success: function (response) {
            show_message(response.title, response.message, response.status, response.time);
            if (response.status == "success") {
                if (!selector.includes("hash") && !selector.includes("upload_file")) {

                    var table = $(selector).DataTable();

                    table.row.add($(`<tr id="tr_${dirname}_${response.id}">
                        ${response.retorno}
                        <td class="text-end">
                            <div class="btn-group dropstart">
                                <button class="btn btn-sm btn-dark dropdown-toggle" type="button" id="dropdownMenuButtonWhite" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-chevron-left"></i>  Opciones</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonWhite">
                                <a class="dropdown-item" href="javascript:void(0);" data-table="tbl_${dirname}" data-type="update" data-id="${response.id}">Editar</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger fw-bold" href="javascript:void(0);" data-table="tbl_${dirname}" data-type="delete" data-id="${response.id}">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
            }`)).draw();
                }
                else if (selector.includes("hash")) {
                    window.location.hash = selector.split("/")[1];
                }
                else if (selector.includes("upload_file")) {
                    var total_input = $("#content_input_files input").length;
                    alert("ok");
                    if (total_input > 0) {
                        $("#content_input_files input").each(function () {
                            var id_inputFile = $(this).attr("id");
                            upload_sigle_file(selector, dirname, id_inputFile, dirname, response.id, total_input);
                            total_input--;
                        });
                    }
                    else {
                        window.location.hash = selector.split("/")[1];
                    }
                }
            }
        },
        complete: function () {
            if (!selector.includes("upload_file")) {
                $(target).attr("disabled", false).html(text);
            }
            $(".modal").modal("hide");
            $(".modal-backdrop").remove();
            $(".modal input").val("");
            limite_caracteres(2);
            setTimeout(function() { $("#body").css("overflow", "scroll"); },600);
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                show_message('Error.', 'Conéctate a una red', 'error', 3000);
            } else if (jqXHR.status == 404) {
                show_message('Error ' + jqXHR.status, 'solicitud no encontrada', 'error', 3000);
            } else if (jqXHR.status == 500) {
                show_message('Error ' + jqXHR.status, 'error interno del servidor', 'error', 3000);
            } else if (exception === 'timeout') {
                show_message('Error.', 'ha excedido el límite de tiempo', 'error', 3000);
            } else {
                show_message('Error', 'Conéctate a una red', 'error', 3000);
            }
        },
    });
}
function edit_row(dirname, file, data, target, hash = 0) {
    var text = $(target).html();
    $.ajax({
        type: "POST",
        url: "../php/c/1/" + dirname + "/" + file + ".php",
        data: data,
        beforeSend: function () {
            $(target).attr("disabled", true).html("Espere...");
        },
        success: function (response) {
            if(response.title!=''){
                show_message(response.title, response.message, response.status, response.time);
            }
            if (response.status == "success") {
                if (hash == 0) {
                    var table = $('#tbl_' + dirname).DataTable();
                    eval(response.rows);
                }
                else if (hash.includes('upload_file/')) {
                    var total_input = $("#content_input_files input").length;
                    if (total_input > 0) {
                        $("#content_input_files input").each(function () {
                            var id_inputFile = $(this).attr("id");
                            upload_sigle_file(hash, dirname, id_inputFile, dirname, response.id, total_input);
                            total_input--;
                        });
                    }
                    else {
                        window.location.hash = hash.split("/")[1];
                    }
                }
                else {
                    window.location.hash = hash;
                }
            }
        },
        complete: function () {
            $(target).attr("disabled", false).html(text);
            $(".modal").modal("hide");
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                show_message('Error.', 'Conéctate a una red', 'error', 3000);
            } else if (jqXHR.status == 404) {
                show_message('Error ' + jqXHR.status, 'solicitud no encontrada', 'error', 3000);
            } else if (jqXHR.status == 500) {
                show_message('Error ' + jqXHR.status, 'error interno del servidor', 'error', 3000);
            } else if (exception === 'timeout') {
                show_message('Error.', 'ha excedido el límite de tiempo', 'error', 3000);
            } else {
                show_message('Error', 'Conéctate a una red', 'error', 3000);
            }
        },
    });
}
function validar_formulario(selector) {
    $(selector).each(function () {
        if ($(this).val().length > 0) {
            $(this).removeClass("is-invalid");
        }
        else {
            $(this).addClass("is-invalid");
        }
    });
}
function show_message(title, message, status, time) {
    if(title!=''){
        switch (status) {
            case 'success':
                var bgColor = "#0f9488";
                break;
    
            case 'error':
                var bgColor = "#b91e1e";
                break;
    
            default:
                break;
        }
        iziToast.show({
            title: title,
            message: message,
            backgroundColor: bgColor,
            titleColor: '#ffffff',
            messageColor: '#ffffff',
            close: true,
            position: 'topRight',
            timeout: time,
        });
    }
}
function loader(selector) {
    $(selector).addClass("disabledevent").append('<div id="loader" class="spinner-grow" role="status" style="position:absolute; left:0; right:0; top:0; bottom:0; margin:auto">' +
        '<span class="sr-only">Loading...</span>' +
        '</div>');
}
function delete_row(dirname, file, data, target) {
    var text = $(target).html();
    $.ajax({
        type: "POST",
        url: "../php/c/1/" + dirname + "/" + file + ".php",
        data: data,
        beforeSend: function () {
            $(target).attr("disabled", true).html("Espere...");
        },
        success: function (response) {
            show_message(response.title, response.message, response.status, response.time);
            if (response.status == "success") {
                $("#tr_" + dirname + "_" + data.id).remove();
            }
        },
        complete: function () {
            $(target).attr("disabled", false).html(text);
            $(".modal").modal("hide");
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                show_message('Error.', 'Conéctate a una red', 'error', 3000);
            } else if (jqXHR.status == 404) {
                show_message('Error ' + jqXHR.status, 'solicitud no encontrada', 'error', 3000);
            } else if (jqXHR.status == 500) {
                show_message('Error ' + jqXHR.status, 'error interno del servidor', 'error', 3000);
            } else if (exception === 'timeout') {
                show_message('Error.', 'ha excedido el límite de tiempo', 'error', 3000);
            } else {
                show_message('Error', 'Conéctate a una red', 'error', 3000);
            }
        },
    });
}
function obtener_atributo_select(id_select, atributo, retorno = 1) {
    var valores = '';
    if (retorno == 1) {
        valores = $('option:selected', id_select).attr(atributo);
    }
    else {
        $('option:selected', id_select).each(function () {
            valores += $(this).attr(atributo) + ', ';
        });
        valores = valores.trim();
        valores = valores.substring(0, valores.length - 1);
    }

    return valores;
}
var cropper_created;
function create_cropper_1(id_modal, width, height, target) {
    var image = new Image();

    var files = target;
    var done = function (url) {
        image.src = url;
        var editor_cropper = document.createElement("div");
        editor_cropper.style.width = '100%';
        editor_cropper.style.height = 'auto';
        // editor_cropper.style.backgroundColor = "#000";

        image.src = URL.createObjectURL(files[0]);
        image.style.width = "100%";
        editor_cropper.appendChild(image);
        $(id_modal + " .modal-body").html(editor_cropper);
        $(id_modal).modal('show');
    };
    var reader;
    var file;

    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }

    $(id_modal).on('shown.bs.modal', function () {
        var minCroppedWidth = width;
        var minCroppedHeight = height;
        var maxCroppedWidth = width;
        var maxCroppedHeight = height;
        cropper_created = new Cropper(image, {
            dragMode: 'none',
            autoCropArea: 0.65,
            restore: false,
            guides: false,
            center: false,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: false,
            toggleDragModeOnDblclick: false,
            zoomable: false,
            background: true,
            data: {
                width: (minCroppedWidth + maxCroppedWidth) / 2,
                height: (minCroppedHeight + maxCroppedHeight) / 2,
            },
        });
        setTimeout(function () {
            if (cropper_created.getCanvasData().naturalWidth < width || cropper_created.getCanvasData().naturalHeight < height) {
                // $(id_modal).modal("hide");
                $(id_modal + " button[data-id]").attr("disabled", true);
                show_message("Error","error",'error',1500);
            }
        }, 100);

    }).on('hidden.bs.modal', function () {
        cropper_created.destroy();
        $(id_modal + " button[data-id]").attr("disabled", false);
        $("input[type='file']").val("");
        // cropper_created = null;
    });
}
function email_format(correo) {
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (regex.test(correo)) {
        return 'success';

    } else {
        return 'error';
    }
}
function delete_img(dir, file, data, target) {
    var text = $(target).html();
    $.ajax({
        type: "POST",
        url: "../php/c/1/" + dir + "/" + file + ".php",
        data: data,
        beforeSend: function () {
            $(target).attr("disabled", true).html("Espere...");
        },
        success: function (data) {
            show_message(data.title, data.message, data.status, data.time);
            eval(data.fn);
        },
        complete: function () {
            $(target).attr("disabled", false).html(text);
            $(".modal").modal("hide");
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                show_message('Error.', 'Conéctate a una red', 'error', 3000);
            } else if (jqXHR.status == 404) {
                show_message('Error ' + jqXHR.status, 'solicitud no encontrada', 'error', 3000);
            } else if (jqXHR.status == 500) {
                show_message('Error ' + jqXHR.status, 'error interno del servidor', 'error', 3000);
            } else if (exception === 'timeout') {
                show_message('Error.', 'ha excedido el límite de tiempo', 'error', 3000);
            } else {
                show_message('Error', 'Conéctate a una red', 'error', 3000);
            }
        },
    })
}
function size_file(bytes) {
    var size;
    if (bytes >= 1073741824) {
        size = (bytes / 1073741824).toFixed(2) + 'gb';
    }
    else if (bytes >= 1048576) {
        size = (bytes / 1048576).toFixed(2) + 'mb';
    }
    else if (bytes >= 1024) {
        size = (bytes / 1024).toFixed(2) + 'kb';
    }
    else if (bytes > 1) {
        size = bytes + 'bytes';
    }
    else if (bytes == 1) {
        size = bytes + 'byte';
    }
    else {
        size = '0 bytes';
    }

    return size;
}
function cerrar_sesion() {
    $.ajax({
        type: "POST",
        url: "../php/c/0/cerrar_sesion.php",
        success: function (data) {
            window.location.href = "../";
        }
    });
}
function mostrar_calendario(id_element, dir, file, show_buttons_header,function_event='',date_calendar='') {
    var botones_header= show_buttons_header == true ? 'prev,today,next' : '';
    var initial_date = date_calendar=='' ? new Date().toISOString().split('T')[0] : date_calendar; 
    $(id_element).fullCalendar({
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day',
            list: 'Agenda',
        },
        header: {
            left: 'title',
            center: '',
            right: botones_header
        },
        defaultDate: initial_date,
        displayEventTime: false,
        events: '../php/c/1/' + dir + '/' + file + '.php',
        eventClick: function (info) {
            switch (function_event) {
                case 'solicitud_vendedores':
                    event_calendar_solicitud_vendedores(info);
                    break;

                case 'calendario_proyectos':
                    event_calendar_proyectos(info);
                    break;

                case 'calendario_entrevista_vendedores':
                    event_entrevistas_vendedores(info);
                    break;

                case 'calendario_entrevista_vacantes':
                    event_entrevistas_vacantes(info);
                    break;
            
                default:
                    break;
            }
        }
    });
}
function flat_pickr(selector, time, month=false) {
    var plugin_month='';
    if(month==true){
        plugin_month= [
            new monthSelectPlugin({
                shorthand: false,
                dateFormat: "m-Y",
                altFormat: "Y-m",
            })
        ]
        
    }
    $(selector).flatpickr({
        enableTime: time,
        noCalendar: false,
        dateFormat: time == true ? "d-m-Y H:i" : "d-m-Y",
        time_24hr: true,
        minDate: "today",
        plugins: plugin_month,
    });
}
function limite_caracteres(tipo=1){
    $("[maxlength]").each(function(){
        var max=$(this).attr("maxlength");
        if(tipo==1){
            if($(this).hasClass("format-number")){
                max-=10;
            }
            $(this).after(`<label class="fs--2 mb-0 pb-0 float-end limit-char fw-light">(0/${max})</label>`);
        }
        else if(tipo==2){
            var valor=$(this).val().length;
            if($(this).hasClass("format-number")){
                max-=10;
            }
            if($(this).siblings(".limit-char").length==0){
                $(this).after(`<label class="fs--2 mb-0 pb-0 float-end limit-char fw-light">(${valor}/${max})</label>`);
            }
            else{
                $(this).siblings(".limit-char").html(`(${valor}/${max})`);
            }
        }
    });
}