$(document).ready(function () {
    /* --------------------------------- INICIO --------------------------------- */
    cambiar_contenido_hash();
    // interval_notificaciones();
    /* ---------------------------------- HASH ---------------------------------- */
    window.onhashchange = function () {
        cambiar_contenido_hash();
    }
    /* --------------------------------- GENERAL -------------------------------- */
    var primera_carga = 0;
    function cambiar_contenido_hash() {
        $(".modal").removeClass("show");
        array_img_delete = [];
        var hash = window.location.hash;
        var hash = hash.replace('#', '');
        var url = window.location.pathname;
        var filename = url.substring(url.lastIndexOf('/') + 1);
        hash_anterior = hash;

        if ((filename.length == 0 || filename == 'inicio.php')) {
            if (hash == '') {
                hash = "propiedades";
                window.location.hash = '#propiedades';
            }
            else if (window.location.hash.indexOf('administrador_') == 1) {
                var id_administrador = hash.split("_");
                get_view_main('administradores', 'editar', { id_administrador: id_administrador[1] }, "#main", 2);
            }
            else if (window.location.hash.indexOf('pass_administrador_') == 1) {
                var id_administrador = hash.split("_");
                get_view_main('administradores', 'contrasena', { id_administrador: id_administrador[2] }, "#main", 2);
            }
            else if (window.location.hash.indexOf('configuracion_') == 1) {
                var id_configuracion = hash.split("_");
                get_view_main('configuraciones', 'editar', { id_configuracion: id_configuracion[1] }, "#main", 2);
            }
            else if(window.location.hash.indexOf('propiedad_') == 1){
                var id_propiedad = hash.split("_");
                get_view_main('propiedades', 'editar', { id_propiedad: id_propiedad[1] }, "#main", 2);
            }
            else if(window.location.hash.indexOf('proyecto_') == 1){
                var id_proyecto = hash.split("_");
                get_view_main('proyectos', 'editar', { id_proyecto: id_proyecto[1] }, "#main", 2);
            }
            else {
                switch (hash) {
                    case "inicio":
                        get_view_main("inicio", "inicio", "", "#main");
                        break;
                    case "logout":
                        cerrar_sesion();
                        break;
                    case "administradores":
                        get_view_main("administradores", "administradores", "", "#main");
                        break;
                    case "nuevo_administrador":
                        get_view_main("administradores", "agregar", "", "#main");
                        break;
                    case "tipo_propiedad":
                        get_view_main("tipo_propiedad", "tipos_propiedad", "", "#main");
                        break;
                    case "nuevo_tipo_propiedad":
                        get_view_main("tipo_propiedad", "agregar", "", "#main");
                        break;
                    case "configuraciones":
                        get_view_main("configuraciones", "configuraciones", "", "#main");
                        break;
                    case "nueva_configuracion":
                        get_view_main("configuraciones", "agregar", "", "#main");
                        break;
                    case "proyectos":
                        get_view_main("proyectos", "proyectos", "", "#main");
                        break;
                    case "nuevo_proyecto":
                        get_view_main("proyectos", "agregar", "", "#main");
                        break;
                    case "propiedades":
                        get_view_main("propiedades", "propiedades", "", "#main");
                        break;
                    case "nueva_propiedad":
                        get_view_main("propiedades", "agregar", "", "#main");
                        break;
                    case "perfil":
                        get_view_main("perfil", "perfil", "", "#main");
                        break;
                    
                    
                }
            }
        }
        else {
            if (primera_carga == 0) {
                primera_carga++;
                window.location.hash = '';
            }
            else {
                primera_carga = 0;
                window.location.href = "inicio.php#" + hash + "";
            }
        }
    }
    
    /* ----------------------------- PERFIL -----------------------------*/

    $(document).on("click","#btn_guardar_correo_cuenta",function(){
        var correo=$("#correo_cuenta").val();
        if(correo.length>0 && email_format(correo)=="success"){
            $("#correo_cuenta").removeClass("is-invalid");
            edit_row("perfil", "guardar_correo", { correo: correo }, $(this),'#perfil');
        }
        else{
            show_message("Error","introduce un correo válido",'error',3000);
            $("#correo_cuenta").addClass("is-invalid");
        }
    });
    // ACTUALIZAR CONTRASEÑA
    $(document).on("click","#btn_guardar_contrasena_cuenta",function(){
        var contrasena=$("#pass_cuenta").val();
        if(contrasena.length>0){
            $("#pass_cuenta").removeClass("is-invalid");
            edit_row("perfil", "guardar_contrasena", { contrasena: contrasena }, $(this));
        }
        else{
            $("#pass_cuenta").addClass("is-invalid");
        }
    });

    /* ------------------------ ADMINISTRADORES ------------------------*/

    // AGREGAR CONTROLADOR
    $(document).on("click", "#btn_agregar_administrador", function () {
        validar_formulario("#content_info input");
        if ($("#content_info .is-invalid").length == 0) {
            var nombre = $("#nombre").val().trim();
            var apellido = $("#apellido").val().trim();
            var correo = $("#correo").val().trim();
            var contrasena = $("#contrasena").val().trim();
            var telefono = $("#telefono").val().replace("-","").replace("(","").replace(")","").replace(" ","").trim();

            edit_row("administradores", "agregar", { nombre:nombre, apellido:apellido, correo:correo, contrasena:contrasena, telefono:telefono }, $(this), "#administradores");
        }
    });

    // EDITAR CONTROLADOR
    $(document).on("click", "#btn_guardar_administrador", function () {
        validar_formulario("#content_info input");
        if ($("#content_info .is-invalid").length == 0) {
            var nombre = $("#nombre").val().trim();
            var apellido = $("#apellido").val().trim();
            var correo = $("#correo").val().trim();
            var telefono = $("#telefono").val().replace("-","").replace("(","").replace(")","").replace(" ","").trim();
            var id=$(this).data("id");
            var user=$(this).data("user");

            edit_row("administradores", "editar", { nombre:nombre, apellido:apellido, correo:correo, telefono:telefono, id:id, user:user }, $(this), "#administradores");
        }
    });
    // CAMBIAR CONTRASEÑA CONTROLADOR
    $(document).on("click", "#btn_contrasena_administrador", function () {
        validar_formulario("#content_info input");
        if ($("#content_info .is-invalid").length == 0) {
            var contrasena = $("#contrasena").val().trim();
            var id=$(this).data("id");

            edit_row("administradores", "contrasena", { contrasena:contrasena, id:id }, $(this), "#administradores");
        }
    });
    // ELIMINAR CONTROLADOR
    $(document).on("click", "#btn_eliminar_administrador", function () {
        var id = $(this).data("id");
        delete_row("administradores", "eliminar", { id: id }, $(this));
    });


    /* ------------------------ PROPIEDADES ------------------------*/

    // TIPO DE PROPIEDAD
    $(document).on("click", "#content_tipo_propiedad input:radio", function () {
        var value = $(this).val();
        value == 1 ? $(".no-terreno").addClass("hidden").find("input").val("").removeClass("required") : $(".no-terreno").removeClass("hidden").find("input").val("").addClass("required");
    });

    // SELECCIÓN DE CARACTERISTICAS
    $(document).on("click", ".check_caracteristica_propiedad", function () {
        if ($(this).is(":checked")) {
            $(this).next().text("Si").parent().next().removeClass("disabledevent").find("input").addClass("required");
            $(this).parent().parent().parent().prev().find(".span-required").removeClass("hidden");
        }
        else {
            $(this).next().text("No").parent().next().addClass("disabledevent").find("input").val("").removeClass("required");
            $(this).parent().parent().parent().prev().find(".span-required").addClass("hidden");
        }
    });

    // SELECCIONAR IMAGEN
    $(document).on("change", "#file_img_propiedad", function (e) {
        if ($(this).val().length > 0) {
            var extension_file = $(this).val().replace(/C:\\fakepath\\/i, '').split('.').pop();
            var filename = $(this).val().split('\\').pop();

            switch (extension_file) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    var formato = extension_file;
                    $("#btn_agregar_img_propiedad").data("formato", formato);
                    $("#btn_agregar_img_propiedad").data("filename", filename);
                    create_cropper_1("#modal_img", 800, 800, e.target.files);
                    break;
                default:
                    $(this).val("");
                    show_message("Error", "Seleccione una imagen con formato jpg, jpeg o png", "error", 3000);
                    break;
            }
        }
    }).on("click", "#btn_agregar_img_propiedad", function () {
        $(this).prop('disabled', true);
        var datosb64 = cropper_created.getCroppedCanvas().toDataURL();
        var formato = $("#btn_agregar_img_propiedad").data("formato");
        var filename = $("#btn_agregar_img_propiedad").data("filename");
        var num = $("#content_imagenes .img-prev").length;

        $("#tip_imagenes").addClass("hidden");
        $("#content_imagenes").append(`<div class="col-12 col-md-6 col-lg-4 img-prev" data-id="${num}">
                <div class="card border">
                    <a href="${datosb64}" data-fancybox="gallery">
                        <img class="card-img-top img-fluid bg-light-alt" data-formato="${formato}" src="${datosb64}">
                    </a>
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h6 class="card-title">${filename}</h6>               
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-end">
                        <a href="javascript:void(0);" id="eliminar_img_prev_propiedad" data-id="${num}" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
                    </div>
                </div>
            </div>`);

        $("#modal_img").modal("hide");
        $("#content_imagenes .img-prev:not(.d-none)").length == 9 ? $("label[for='file_img_propiedad']").addClass("disabledevent") : $("label[for='file_img_propiedad']").removeClass("disabledevent");
    });

    // ELIMINAR IMAGEN PREVIA
    $(document).on("click", "#eliminar_img_prev_propiedad", function () {
        var id = $(this).attr("data-id");
        $("#tab_imagenes .img-prev[data-id='" + id + "']").addClass("d-none");

        var num = $("#tab_imagenes .img-prev").length;

        if (num == 0) {
            $("#tip_imagenes").removeClass("hidden");
        }
        else {
            $("#tab_imagenes .img-prev").each(function (index) {
                $(this).attr("data-id", index).find("#eliminar_img_prev_propiedad").attr("data-id", index);
            });
        }
        $("label[for='file_img_propiedad']").removeClass("disabledevent");
        $("#content_imagenes .img-prev:not(.d-none)").length == 9 ? $("label[for='file_img_propiedad']").addClass("disabledevent") : $("label[for='file_img_propiedad']").removeClass("disabledevent");
    });

    // AGREGAR PROPIEDAD
    $(document).on("click","#btn_agregar_propiedad", function () {
         // VALIDACIÓN DE DIRECCIÓN
        validar_formulario("#content_direccion input");
        if ($("#content_direccion .is-invalid").length == 0 && $("#lat_direccion").val() != 0 && $("#lon_direccion").val() != 0) {
            // VALIDACIÓN DE DETALLES
            validar_formulario("#tab_detalles .required");
            if ($("#tab_detalles .is-invalid").length == 0) {
                // VALIDACIÓN DE CARACTERISTICAS
                validar_formulario("#tab_caracteristicas .required");
                if ($("#tab_caracteristicas .is-invalid").length == 0) {
                    // VALIDACIÓN IMAGENES
                    if ($("#content_imagenes .img-prev:not(.d-none) img").length > 0) {
                        var direccion = $("#direccion").val().trim();
                        var lat_direccion = $("#lat_direccion").val();
                        var lon_direccion = $("#lon_direccion").val();
                        var id_tipo_propiedad = $("input[name='id_tipo_propiedad']:checked").val();
                        var id_tipo_venta = $("input[name='id_tipo_venta']:checked").val();
                        var descripcion = $("#descripcion").val().trim();
                        var precio = $("#precio").val().trim();
                        var mts = $("#mts").val().trim();
                        var caracteristicas = [];

                        $("#tab_caracteristicas input:checked").each(function (index) {
                            var id = $(this).data("id");
                            var tipo = $(this).data("tipo");
                            if (tipo == 2) {
                                var cant = $(this).parent().next().find("input").val();
                            }
                            else {
                                var cant = 0;
                            }
                            caracteristicas[index] = { id: id, tipo: tipo, cant: cant };
                        });

                        var img = [];
                        $("#tab_imagenes img").each(function (index) {
                            var id = $(this).data("id") != undefined ? 1 : 0;
                            if (!$(this).parent().parent().parent().hasClass("d-none")) {
                                img[index] = { src: $(this).attr("src"), formato: $(this).data("formato"), id: id }
                            }
                        });

                        edit_row("propiedades", "agregar", { direccion: direccion, lat_direccion: lat_direccion, lon_direccion: lon_direccion, id_tipo_propiedad: id_tipo_propiedad, id_tipo_venta: id_tipo_venta, descripcion: descripcion, precio: precio, mts: mts, caracteristicas: JSON.stringify(caracteristicas), img: JSON.stringify(img) }, $(this), "#propiedades");
                    }
                    else {
                        show_message("Error", "por favor seleccione al menos una imagen", "error", 3000);
                        $("button[data-tab='#tab_imagenes']").trigger("click");
                    }
                }
                else {
                    show_message("Error", "por favor los campos requeridos", "error", 3000);
                    $("button[data-tab='#tab_caracteristicas']").trigger("click");
                }
            }
            else {
                show_message("Error", "por favor los campos requeridos", "error", 3000);
                $("button[data-tab='#tab_detalles']").trigger("click");
            }
        }
        else {
            if ($("#direccion").val() == "") {
                show_message("Error", "por favor agrega una dirección", "error", 3000);
            }
            else if ($("#lat_direccion").val() == 0 && $("#lon_direccion").val() == 0) {
                show_message("Error", "por favor utiliza el autocompletado de Google maps", "error", 3000);
            }
            $("button[data-tab='#tab_ubicacion']").trigger("click");
        }
    });

    // EDITAR CONTROLADOR
    $(document).on("click", "#btn_guardar_propiedad", function () {
        // VALIDACIÓN DE DIRECCIÓN
        validar_formulario("#content_direccion input");
        if ($("#content_direccion .is-invalid").length == 0 && $("#lat_direccion").val() != 0 && $("#lon_direccion").val() != 0) {
            // VALIDACIÓN DE DETALLES
            validar_formulario("#tab_detalles .required");
            if ($("#tab_detalles .is-invalid").length == 0) {
                // VALIDACIÓN DE CARACTERISTICAS
                validar_formulario("#tab_caracteristicas .required");
                if ($("#tab_caracteristicas .is-invalid").length == 0) {
                    // VALIDACIÓN IMAGENES
                    if ($("#content_imagenes .img-prev:not(.d-none) img").length > 0) {
                        var direccion = $("#direccion").val().trim();
                        var lat_direccion = $("#lat_direccion").val();
                        var lon_direccion = $("#lon_direccion").val();
                        var id_tipo_propiedad = $("input[name='id_tipo_propiedad']:checked").val();
                        var id_tipo_venta = $("input[name='id_tipo_venta']:checked").val();
                        var descripcion = $("#descripcion").val().trim();
                        var precio = $("#precio").val().trim();
                        var mts = $("#mts").val().trim();
                        var id = $(this).data("id");
                        var caracteristicas = [];
                        var caracteristicas_not = [];

                        $("#tab_caracteristicas input:checked").each(function (index) {
                            var id = $(this).data("id");
                            var tipo = $(this).data("tipo");
                            if (tipo == 2) {
                                var cant = $(this).parent().next().find("input").val();
                            }
                            else {
                                var cant = 0;
                            }
                            caracteristicas[index] = { id: id, tipo: tipo, cant: cant };
                        });

                        $("#tab_caracteristicas input:checkbox:not(:checked)").each(function (index) {
                            var id = $(this).data("id");
                            caracteristicas_not[index] = { id: id };
                        });

                        var img = [];
                        var img_not = [];
                        $("#tab_imagenes img").each(function (index) {
                            var id = $(this).data("id") != undefined ? 1 : 0;
                            if (!$(this).parent().parent().parent().hasClass("d-none")) {
                                img[index] = { src: $(this).attr("src"), formato: $(this).data("formato"), id: id }
                            }
                        });
                        $("#content_imagenes [data-id].d-none").each(function (index) {
                            img_not[index] = { src: $(this).find("img").attr("src") }
                        });

                        edit_row("propiedades", "editar", { direccion: direccion, lat_direccion: lat_direccion, lon_direccion: lon_direccion, id_tipo_propiedad: id_tipo_propiedad, id_tipo_venta: id_tipo_venta, descripcion: descripcion, precio: precio, mts: mts, caracteristicas: JSON.stringify(caracteristicas), caracteristicas_not: JSON.stringify(caracteristicas_not), img: JSON.stringify(img), img_not: JSON.stringify(img_not), id: id }, $(this), "#propiedades");
                    }
                    else {
                        show_message("Error", "por favor seleccione al menos una imagen", "error", 3000);
                        $("button[data-tab='#tab_imagenes']").trigger("click");
                    }
                }
                else {
                    show_message("Error", "por favor los campos requeridos", "error", 3000);
                    $("button[data-tab='#tab_caracteristicas']").trigger("click");
                }
            }
            else {
                show_message("Error", "por favor los campos requeridos", "error", 3000);
                $("button[data-tab='#tab_detalles']").trigger("click");
            }
        }
        else {
            if ($("#direccion").val() == "") {
                show_message("Error", "por favor agrega una dirección", "error", 3000);
            }
            else if ($("#lat_direccion").val() == 0 && $("#lon_direccion").val() == 0) {
                show_message("Error", "por favor utiliza el autocompletado de Google maps", "error", 3000);
            }
            $("button[data-tab='#tab_ubicacion']").trigger("click");
        }
    });

    // ELIMINAR PROPIEDAD
    $(document).on("click", "#btn_eliminar_propiedad", function () {
        var id = $(this).data("id");
        delete_row("propiedades", "eliminar", {id:id}, $(this));
    });

    /* ------------------- TIPOS DE  PROPIEDADES -------------------*/

    // AGREGAR TIPO DE PROPIEDAD
    $(document).on("click", "#btn_agregar_tipo_propiedad", function() {
        validar_formulario("#content_info_add input");
        if($("#content_info_add .is-invalid").length == 0){
            var propiedad = $("#nombre_tipo").val().trim();
            add_row("tipos_propiedad", "agregar", {propiedad:propiedad}, "#tbl_tipos_propiedad", $(this));
        }
    });

    // EDITAR TIPO DE PROPIEDAD CONTROLADOR
    $(document).on("click", "#btn_guardar_tipo_propiedad", function(){
        validar_formulario("content_info_update input:not([type='search'])");
        if($("#content_info_update .is-invalid").length == 0){
            var propiedad = $("#nombre_tipo_propiedad_edit").val().trim();
            var id = $(this).data("id");
            var table = $('#tbl_tipos_propiedad').DataTable();
            var position = table.row($("#tr_tipos_propiedad_" + id)).index();
            edit_row("tipos_propiedad", "editar", {propiedad:propiedad, id:id, position:position}, $(this));
        }
    });

    // ELIMINAR TIPO DE PROPIEDAD CONTROLADOR
    $(document).on("click", "#btn_eliminar_tipo_propiedad", function() {
        var id = $(this).data("id");
        delete_row("tipos_propiedad", "eliminar", {id:id}, $(this));
    });

    /* ------------------------ CONFIGURACIONES ------------------------*/

    $(document).on("click", "#btn_guardar_config", function() {
        // validar_formulario("#content_config input:not([type='search'])");
        if($("#content_images_banner .img-prev-banner:not(.d-none) img").length> 0 && $("#content_images_seccion_1 .img-prev-seccion_1:not(.d-none) img").length>0 && $("#content_images_seccion_3 .img-prev-seccion_3:not(.d-none) img").length>0){
            if ($("#content_config .is-invalid").length == 0) {
                var valores=[];
    
                $("#content_config input").each(function(index){
                    valores[index]={ value:$(this).val().trim(), id:$(this).data("id") }
                });
                
                var img_banner = [];
                $("#tab_banner img").each(function (index) {
                    var id = $(this).data("id") != undefined ? 1 : 0;
                    if (!$(this).parent().parent().parent().hasClass("d-none")) {
                        img_banner[index] = { src: $(this).attr("src"), formato: $(this).data("formato"), id: id }
                    } 
                });
                var not_img_banner = [];
                $("#content_images_banner [data-id].d-none").each(function (index) {
                    not_img_banner[index] = { src: $(this).find("img").attr("src") }
                });
    
                var img_seccion_1 = [];
                $("#tab_seccion1 img").each(function (index) {
                    var id = $(this).data("id") != undefined ? 1 : 0;
                    if (!$(this).parent().parent().parent().hasClass("d-none")) {
                        img_seccion_1[index] = { src: $(this).attr("src"), formato: $(this).data("formato"), id: id }
                    } 
                });
    
                var not_img_seccion_1 = [];
                $("#content_images_seccion_1 [data-id].d-none").each(function (index) {
                    not_img_seccion_1[index] = { src: $(this).find("img").attr("src") }
                });
    
                var img_seccion_3 = [];
                $("#tab_seccion3 img").each(function (index) {
                    var id = $(this).data("id") != undefined ? 1 : 0;
                    if (!$(this).parent().parent().parent().hasClass("d-none")) {
                        img_seccion_3[index] = { src: $(this).attr("src"), formato: $(this).data("formato"), id: id }
                    } 
                });
    
                var not_img_seccion_3 = [];
                $("#content_images_seccion_3 [data-id].d-none").each(function (index) {
                    not_img_seccion_3[index] = { src: $(this).find("img").attr("src") }
                });
    
    
                edit_row("configuraciones", "guardar", { valores:JSON.stringify(valores), img_banner:JSON.stringify(img_banner), not_img_banner:JSON.stringify(not_img_banner), 
                img_seccion_1:JSON.stringify(img_seccion_1), not_img_seccion_1:JSON.stringify(not_img_seccion_1), img_seccion_3:JSON.stringify(img_seccion_3), not_img_seccion_3:JSON.stringify(not_img_seccion_3) }, $(this));
            }
        }
        else{
            show_message("Error","please add an image","error",3000);
        }
    });

    // IMAGENES BANNER
    // AGREGAR IMAGEN BANNER
    $(document).on("change", "#imagenes_banner", function (e) {
        if ($(this).val().length > 0) {
            var extension_file = $(this).val().replace(/C:\\fakepath\\/i, '').split('.').pop();
            var filename = $(this).val().split('\\').pop();

            switch (extension_file) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    var formato = extension_file;
                    $("#btn_add_img_banner").data("formato", formato);
                    $("#btn_add_img_banner").data("filename", filename);
                    create_cropper_1("#modal_img_banner", 1400, 800, e.target.files);
                    break;
                default:
                    $(this).val("");
                    show_message("Error", "Select an image in jpg, jpeg or png format", "error", 3000);
                    break;
            }
        }
        $("#btn_add_img_banner").prop('disabled', false);

    }).on("click", "#btn_add_img_banner", function (e) {
        $(this).prop('disabled', true);
        var datosb64 = cropper_created.getCroppedCanvas().toDataURL();
        var formato = $(this).data("formato");
        var filename = $(this).data("filename");
        var num = $("#content_images_banner .img-prev-banner").length;
        
        $("#content_images_banner").append(`<div class="col-12 col-md-4 col-lg-4 mb-3 img-prev-banner" data-id="${num}">
        <div class="card border">
            <a href="${datosb64}" data-fancybox="gallery">
                <img class="card-img-top img-fluid bg-light-alt" data-formato="${formato}" src="${datosb64}">
            </a>
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">                      
                        <h6 class="card-title">${filename}</h6>               
                    </div>
                </div>
            </div>
            <div class="card-body text-end">
                <a href="javascript:void(0);" id="eliminar_img_prev_banner" data-id="${num}" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
            </div>
        </div>
    </div>`);
    
    $("#modal_img_banner").modal("hide");
    $("#content_images_banner .img-prev-banner:not(.d-none)").length == 1 ? $("label[for='imagenes_banner']").addClass("disabledevent") : $("label[for='imagenes_banner']").removeClass("disabledevent");

    });

    // ELIMINAR IMAGEN PREVIA BANNER
    $(document).on("click", "#eliminar_img_prev_banner", function () {
        var id = $(this).attr("data-id");
        $("#content_images_banner .img-prev-banner[data-id='" + id + "']").addClass("d-none");

        var num = $("#content_images_banner .img-prev-banner").length;

            $("#content_images_portada .img-prev-portada").each(function (index) {
                $(this).attr("data-id", index).find("#eliminar_img_prev_banner").attr("data-id", index);
            });
        
        $("label[for='imagenes_banner']").removeClass("disabledevent");
    });

    // IMAGENES SECCION 1
    // AGREGAR IMAGEN SECCION 1
    $(document).on("change", "#imagenes_seccion_1", function (e) {
        if ($(this).val().length > 0) {
            var extension_file = $(this).val().replace(/C:\\fakepath\\/i, '').split('.').pop();
            var filename = $(this).val().split('\\').pop();

            switch (extension_file) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    var formato = extension_file;
                    $("#btn_add_img_seccion_1").data("formato", formato);
                    $("#btn_add_img_seccion_1").data("filename", filename);
                    create_cropper_1("#modal_img_seccion_1", 550, 680, e.target.files);
                    break;
                default:
                    $(this).val("");
                    show_message("Error", "Select an image in jpg, jpeg or png format", "error", 3000);
                    break;
            }
        }
        $("#btn_add_img_seccion_1").prop('disabled', false);

    }).on("click", "#btn_add_img_seccion_1", function (e) {
        $(this).prop('disabled', true);
        var datosb64 = cropper_created.getCroppedCanvas().toDataURL();
        var formato = $(this).data("formato");
        var filename = $(this).data("filename");
        var num = $("#content_images_seccion_1 .img-prev-seccion_1").length;
        
        $("#content_images_seccion_1").append(`<div class="col-12 col-md-4 col-lg-4 mb-3 img-prev-seccion_1" data-id="${num}">
        <div class="card border">
            <a href="${datosb64}" data-fancybox="gallery">
                <img class="card-img-top img-fluid bg-light-alt" data-formato="${formato}" src="${datosb64}">
            </a>
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">                      
                        <h6 class="card-title">${filename}</h6>               
                    </div>
                </div>
            </div>
            <div class="card-body text-end">
                <a href="javascript:void(0);" id="eliminar_img_prev_seccion_1" data-id="${num}" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
            </div>
        </div>
    </div>`);
    
    $("#modal_img_seccion_1").modal("hide");
    $("#content_images_seccion_1 .img-prev-seccion_1:not(.d-none)").length == 1 ? $("label[for='imagenes_seccion_1']").addClass("disabledevent") : $("label[for='imagenes_seccion_1']").removeClass("disabledevent");

    });

    // ELIMINAR IMAGEN PREVIA SECCION 1
    $(document).on("click", "#eliminar_img_prev_seccion_1", function () {
        var id = $(this).attr("data-id");
        $("#content_images_seccion_1 .img-prev-seccion_1[data-id='" + id + "']").addClass("d-none");

        var num = $("#content_images_seccion_1 .img-prev-seccion_1").length;

            $("#content_images_seccion_1 .img-prev-seccion_1").each(function (index) {
                $(this).attr("data-id", index).find("#eliminar_img_prev_seccion_1").attr("data-id", index);
            });
        
        $("label[for='imagenes_seccion_1']").removeClass("disabledevent");
    });

    // IMAGENES SECCION 3
    // AGREGAR IMAGEN SECCION 3
    $(document).on("change", "#imagenes_seccion_3", function (e) {
        if ($(this).val().length > 0) {
            var extension_file = $(this).val().replace(/C:\\fakepath\\/i, '').split('.').pop();
            var filename = $(this).val().split('\\').pop();

            switch (extension_file) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    var formato = extension_file;
                    $("#btn_add_img_seccion_3").data("formato", formato);
                    $("#btn_add_img_seccion_3").data("filename", filename);
                    create_cropper_1("#modal_img_seccion_3", 700, 570, e.target.files);
                    break;
                default:
                    $(this).val("");
                    show_message("Error", "Select an image in jpg, jpeg or png format", "error", 3000);
                    break;
            }
        }
        $("#btn_add_img_seccion_3").prop('disabled', false);

    }).on("click", "#btn_add_img_seccion_3", function (e) {
        $(this).prop('disabled', true);
        var datosb64 = cropper_created.getCroppedCanvas().toDataURL();
        var formato = $(this).data("formato");
        var filename = $(this).data("filename");
        var num = $("#content_images_seccion_3 .img-prev-seccion_3").length;
        
        $("#content_images_seccion_3").append(`<div class="col-12 col-md-4 col-lg-4 mb-3 img-prev-seccion_3" data-id="${num}">
        <div class="card border">
            <a href="${datosb64}" data-fancybox="gallery">
                <img class="card-img-top img-fluid bg-light-alt" data-formato="${formato}" src="${datosb64}">
            </a>
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">                      
                        <h6 class="card-title">${filename}</h6>               
                    </div>
                </div>
            </div>
            <div class="card-body text-end">
                <a href="javascript:void(0);" id="eliminar_img_prev_seccion_3" data-id="${num}" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
            </div>
        </div>
    </div>`);
    
    $("#modal_img_seccion_3").modal("hide");
    $("#content_images_seccion_3 .img-prev-seccion_3:not(.d-none)").length == 1 ? $("label[for='imagenes_seccion_3']").addClass("disabledevent") : $("label[for='imagenes_seccion_3']").removeClass("disabledevent");

    });

    // ELIMINAR IMAGEN PREVIA SECCION 3
    $(document).on("click", "#eliminar_img_prev_seccion_3", function () {
        var id = $(this).attr("data-id");
        $("#content_images_seccion_3 .img-prev-seccion_3[data-id='" + id + "']").addClass("d-none");

        var num = $("#content_images_seccion_3 .img-prev-seccion_3").length;

            $("#content_images_seccion_3 .img-prev-seccion_3").each(function (index) {
                $(this).attr("data-id", index).find("#eliminar_img_prev_seccion_3").attr("data-id", index);
            });
        
        $("label[for='imagenes_seccion_3']").removeClass("disabledevent");
    });

    // // AGREGAR CONFIGURACION
    // $(document).on("click", "#btn_agregar_configuracion", function() {
    //     validar_formulario("#content_info input");
    //     validar_formulario("#content_info textarea");
    //     if($("#content_info .is-invalid").length == 0){
    //         var titulo = $("#Titulo").val().trim();
    //         var descripcion = $("#Descripcion").val().trim();

    //         edit_row("configuraciones", "agregar", {titulo:titulo, descripcion:descripcion} , $(this), "#configuraciones");
    //     }

    // });

    // // EDITAR CONTROLADOR
    // $(document).on("click", "#btn_guardar_configuracion", function() {
    //     validar_formulario("#content_info input");
    //     validar_formulario("#content_info textarea");
    //     if ($("#content_info .is-invalid").length == 0) {
    //         var titulo = $("#Titulo").val().trim();
    //         var descripcion = $("#Descripcion").val().trim();
    //         var id=$(this).data("id");

    //         edit_row("configuraciones", "editar", { titulo:titulo, descripcion:descripcion, id:id }, $(this), "#configuraciones");
    //     }
    // });

    // // ELIMINAR CONFIGURACION
    // $(document).on("click", "#btn_eliminar_configuracion", function() {
    //     var id = $(this).data("id");
    //     delete_row("configuraciones", "eliminar", {id:id}, $(this));
    // });

    /* ------------------------ PROYECTOS ------------------------*/

    $(document).on("click", "#id_media2", function(){
        $('a[href="#tab_media"]')[0].click();
    });

    $(document).on("click", 'a[href="#tab_media"]', function(){
        var tipo = $("#tab_media")[0].getAttribute('data-active-media');
        if(tipo == 1){
            $("#media_imagenes").removeClass("active");
            $("#media_imagenes")[0].click();
        }
        else if(tipo == 2){
            $("#media_videos").removeClass("active");
            $("#media_videos")[0].click();
        }
    });

    $(document).on("click", '[tipo_media]', function(){
        var tipo = $(this)[0].getAttribute('tipo_media');
        $('[data-active-media]')[0].setAttribute('data-active-media', tipo);
    });

    $(document).on("click", "#cancelar_media", function(){
        var tipo = $("#tab_media")[0].getAttribute('data-active-media');
        if(tipo == 1){
            $("#media_imagenes").removeClass("active");
        }
        else if(tipo == 2){
            var url = $("#content_videos .vid-prev:not(.d-none) iframe").attr('src');
            $("#content_videos .vid-prev:not(.d-none) iframe").attr('src', url);
            $("#media_videos").removeClass("active");
        }
        $("#tab_imagenes_proyecto").removeClass("active");
        $("#tab_videos").removeClass("active");
        $('[data-active-media]')[0].setAttribute('data-active-media', 0);
        $("#tab_media").addClass("active");
    });

    // AGREGAR VIDEO
    $(document).on("click", "#agregar_video", function() {
        var url = $("#url_youtube").val().trim();
        if(url.includes('www.youtube.com/watch') || url.includes('youtu.be')){
            var num = $("#content_videos .vid-prev").length;
            var url_id = youtube_parser(url);
            var embed = 'https://www.youtube.com/embed/' + url_id + '?rel=0&modestbranding=1&listType=playlist&showinfo=0&iv_load_policy=3';
            // Si ha aparecido correctamente
            if(url_id != false){
                $("#modal_videos .modal-body").append(`
                <div class="border vid-prev" data-id="${num}">
                    <div class="card-body">
                        <div class="ratio ratio-21x9">
                            <iframe src="${embed}" data-url-og="${url}" title="YouTube video" allowfullscreen></iframe>
                        </div>                                  
                    </div>
                </div>
                `);
                $("#btn_agregar_video").addClass("disabled");
                $("#modal_videos").modal("show");
                setTimeout(function(){ $("#btn_agregar_video").removeClass("disabled"); }, 5000);
            }
            else{
                show_message("Error", "Algo ha salido mal, Utilice un link valido de youtube", "error", 3000);                   
            }
        }
        else{
            show_message("Error", "Utilice un link valido de youtube", "error", 3000);
        }
    }).on("click", "#btn_agregar_video", function() {
        var num = $("#content_videos .vid-prev").length;
        var embed = $("#modal_videos iframe").attr('src');
        var url = $("#modal_videos iframe").attr('data-url-og');
        $("#content_videos").append(`
        <div class="border vid-prev" data-id="${num}">
            <div class="card-body">
                <div class="ratio ratio-21x9">
                    <iframe src="${embed}" data-url-og="${url}" title="YouTube video" allowfullscreen></iframe>
                </div>                                  
            </div>
            <div class="card-body text-end">
                <a href="javascript:void(0);" id="eliminar_prev_videos" data-id="${num}" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
            </div>
        </div>
        `);
        $("#modal_videos").modal("hide");
        $("#content_videos .vid-prev:not(.d-none)").length == 1 ? $("#agregar_video").addClass("disabledevent") : $("#agregar_video").removeClass("disabledevent");
        setTimeout(function(){ $("#modal_videos .modal-body div").remove(); }, 2000);

    });

    // LIMPIAR MODAL
    $(document).on("click", '#modal_videos button[data-bs-dismiss="modal"]', function() {
        setTimeout(function() { $("#modal_videos .modal-body div").remove(); }, 200);
    });

    // ELIMINAR VIDEO PREVIO
    $(document).on("click", "#eliminar_prev_videos", function() {
        var id = $(this).data("id");
        $("#modal_videos .modal-body div").remove();
        // $("#modal_videos .vid-prev[data-id='"+id+"']").addClass("d-none");
        // $("#modal_videos .vid-prev[data-id='"+id+"'] iframe").attr('src', '');
        $("#content_videos .vid-prev[data-id='"+id+"']").addClass("d-none");
        $("#content_videos .vid-prev[data-id='"+id+"'] iframe").attr('src', '');
        $("#content_videos .vid-prev:not(.d-none)").length == 1 ? $("#agregar_video").addClass("disabledevent") : $("#agregar_video").removeClass("disabledevent");

    });

    // SELECCIONAR IMAGEN
    $(document).on("change", "#file_img_proyecto", function (e) {
        if ($(this).val().length > 0) {
            var extension_file = $(this).val().replace(/C:\\fakepath\\/i, '').split('.').pop();
            var filename = $(this).val().split('\\').pop();

            switch (extension_file) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    var formato = extension_file;
                    $("#btn_agregar_img_proyecto").data("formato", formato);
                    $("#btn_agregar_img_proyecto").data("filename", filename);
                    create_cropper_1("#modal_img", 800, 800, e.target.files);
                    break;
                default:
                    $(this).val("");
                    show_message("Error", "Seleccione una imagen con formato jpg, jpeg o png", "error", 3000);
                    break;
            }
        }
    }).on("click", "#btn_agregar_img_proyecto", function () {
        $(this).prop('disabled', true);
        var datosb64 = cropper_created.getCroppedCanvas().toDataURL();
        var formato = $("#btn_agregar_img_proyecto").data("formato");
        var filename = $("#btn_agregar_img_proyecto").data("filename");
        var num = $("#content_imagenes .img-prev").length;

        $("#tip_imagenes").addClass("hidden");
        $("#content_imagenes").append(`<div class="col-12 col-md-6 col-lg-4 img-prev" data-id="${num}">
                <div class="card border">
                    <a href="${datosb64}" data-fancybox="gallery">
                        <img class="card-img-top img-fluid bg-light-alt" data-formato="${formato}" src="${datosb64}">
                    </a>
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h6 class="card-title">${filename}</h6>               
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-end">
                        <a href="javascript:void(0);" id="eliminar_img_prev_proyecto" data-id="${num}" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
                    </div>
                </div>
            </div>`);

        $("#modal_img").modal("hide");
        $("#content_imagenes .img-prev:not(.d-none)").length == 9 ? $("label[for='file_img_proyecto']").addClass("disabledevent") : $("label[for='file_img_proyecto']").removeClass("disabledevent");
    });

    // ELIMINAR IMAGEN PREVIA
    $(document).on("click", "#eliminar_img_prev_proyecto", function () {
        var id = $(this).attr("data-id");
        $("#tab_imagenes_proyecto .img-prev[data-id='" + id + "']").addClass("d-none");

        var num = $("#tab_imagenes_proyecto .img-prev").length;

        if (num == 0) {
            $("#tab_imagenes_proyecto").removeClass("hidden");
        }
        else {
            $("#tab_imagenes_proyecto .img-prev").each(function (index) {
                $(this).attr("data-id", index).find("#eliminar_img_prev_proyecto").attr("data-id", index);
            });
        }
        $("label[for='file_img_proyecto']").removeClass("disabledevent");
        $("#content_imagenes .img-prev:not(.d-none)").length == 9 ? $("label[for='file_img_proyecto']").addClass("disabledevent") : $("label[for='file_img_proyecto']").removeClass("disabledevent");
    });

    // AGREGAR CONTROLADOR
    $(document).on("click", "#btn_agregar_proyecto", function() {
        // DIFERENCIA SI SUBIRA IMAGEN O VIDEO
        var tipo = $("#tab_media")[0].getAttribute('data-active-media');
        // VALIDACION DETALLE
        validar_formulario("#tab_detalles .required");
        if($("#tab_detalles .is-invalid").length == 0){
            // VALIDACION DIRECCION
            validar_formulario("#content_direccion input");
            if ($("#content_direccion .is-invalid").length == 0 && $("#lat_direccion").val() != 0 && $("#lon_direccion").val() != 0) {
                // VALIDACION IMAGENES O VIDEO
                if((tipo == 1 && $("#content_imagenes .img-prev:not(.d-none) img").length > 0) || (tipo == 2 && $("#content_videos .vid-prev:not(.d-none) iframe").length > 0)){

                    var descripcion = $("#descripcion").val().trim();
                    var precio = $("#precio").val().trim();
                    var mts = $("#metros_cuadrados").val().trim();
                    var direccion = $("#direccion").val().trim();
                    var lat_direccion = $("#lat_direccion").val().trim();
                    var lon_direccion = $("#lon_direccion").val().trim();
                    var tipo_propiedad = $("input[name='id_tipo_propiedad']:checked").val().trim();
                    var url_video = $("#content_videos .vid-prev:not(.d-none) iframe").attr('data-url-og');
                    
                    if(tipo == 1){
                        var img = [];
                        $("#tab_imagenes_proyecto img").each(function (index) {
                            var id = $(this).data("id") != undefined ? 1 : 0;
                            if (!$(this).parent().parent().parent().hasClass("d-none")) {
                                img[index] = { src: $(this).attr("src"), formato: $(this).data("formato"), id: id }
                            } 
                        });
                    }

                    edit_row("proyectos", "agregar", {descripcion:descripcion, precio:precio, mts:mts, direccion:direccion, lat_direccion:lat_direccion, lon_direccion:lon_direccion, tipo_propiedad:tipo_propiedad, url_video:url_video, tipo:tipo, img: JSON.stringify(img) }, $(this), "#proyectos");                   
                }
                else {
                    show_message("Error", "por favor agregue una imagen o video", "error", 3000);
                }
            }
            else{
                if ($("#direccion").val() == "") {
                    show_message("Error", "por favor agrega una dirección", "error", 3000);
                }
                else if ($("#lat_direccion").val() == 0 && $("#lon_direccion").val() == 0) {
                    show_message("Error", "por favor utiliza el autocompletado de Google maps", "error", 3000);
                }
                $("button[data-tab='#tab_ubicacion']").trigger("click");
            }
        }
        else{
            show_message("Error","por favor llene los campos requeridos", "error", 3000);
            $("button[data-tab='#tab_detalles']").trigger("click");
        }
    });

    // EDITAR CONTROLADOR
    $(document).on("click", "#btn_guardar_proyecto", function() {
        // DIFERENCIA SI SUBIRA IMAGEN O VIDEO
        var tipo = $("#tab_media")[0].getAttribute('data-active-media');
        // VALIDACION DETALLE
        validar_formulario("#tab_detalles .required");
        if($("#tab_detalles .is-invalid").length == 0){
            // VALIDACION DIRECCION
            validar_formulario("#content_direccion input");
            if ($("#content_direccion .is-invalid").length == 0 && $("#lat_direccion").val() != 0 && $("#lon_direccion").val() != 0) {
                // VALIDACION IMAGENES O VIDEO
                if((tipo == 1 && $("#content_imagenes .img-prev:not(.d-none) img").length > 0) || (tipo == 2 && $("#content_videos .vid-prev:not(.d-none) iframe").length > 0)){
                    var id = $(this).data("id");
                    var descripcion = $("#descripcion").val().trim();
                    var precio = $("#precio").val().trim();
                    var mts = $("#metros_cuadrados").val().trim();
                    var direccion = $("#direccion").val().trim();
                    var lat_direccion = $("#lat_direccion").val().trim();
                    var lon_direccion = $("#lon_direccion").val().trim();
                    var tipo_propiedad = $("input[name='id_tipo_propiedad']:checked").val().trim();
                    var url_video = $("#content_videos .vid-prev:not(.d-none) iframe").attr('data-url-og');

                    if(tipo == 1){
                        var img = [];
                        var img_not = [];
                        $("#tab_imagenes_proyecto img").each(function (index) {
                            var id = $(this).data("id") != undefined ? 1 : 0;
                            if (!$(this).parent().parent().parent().hasClass("d-none")) {
                                img[index] = { src: $(this).attr("src"), formato: $(this).data("formato"), id: id }
                            } 
                        });
                        $("#content_imagenes [data-id].d-none").each(function (index) {
                            img_not[index] = { src: $(this).find("img").attr("src") }
                        });
                        
                    }

                    edit_row("proyectos", "editar", {id:id, descripcion:descripcion, precio:precio, mts:mts, direccion:direccion, lat_direccion:lat_direccion, lon_direccion:lon_direccion, tipo_propiedad:tipo_propiedad, url_video:url_video, tipo:tipo, img: JSON.stringify(img), img_not: JSON.stringify(img_not) }, $(this), "#proyectos");                   
                }
                else {
                    show_message("Error", "por favor agregue una imagen o video", "error", 3000);
                }
            }
            else{
                if ($("#direccion").val() == "") {
                    show_message("Error", "por favor agrega una dirección", "error", 3000);
                }
                else if ($("#lat_direccion").val() == 0 && $("#lon_direccion").val() == 0) {
                    show_message("Error", "por favor utiliza el autocompletado de Google maps", "error", 3000);
                }
                $("button[data-tab='#tab_ubicacion']").trigger("click");
            }
        }
        else{
            show_message("Error","por favor llene los campos requeridos", "error", 3000);
            $("button[data-tab='#tab_detalles']").trigger("click");
        }
    });

    // ELIMINAR CONTROLADOR
    $(document).on("click", "#btn_eliminar_proyecto", function() {
        var id = $(this).data(id);
        delete_row("proyecto", "eliminar", { id:id }, $(this));
    });

});
// FUNCIONES
function matchYoutubeUrl(url){
var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    return (url.match(p)) ? RegExp.$1 : false ;
}

function youtube_parser(url){
    var regExp = /.*(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;
    var match = url.match(regExp);
    return (match&&match[1].length==11)? match[1] : false;
}

