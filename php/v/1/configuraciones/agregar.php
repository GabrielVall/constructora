<?php
session_start();
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

// $row_categorias = $sql->obtenerResultado("CALL sp_select_categorias_blog1()");
// $total_row_categorias = count($row_categorias);

// $row_usuarios = $sql->obtenerResultado("CALL sp_select_usuarios1()");
// $total_row_usuarios = count($row_usuarios);

// $row_usuario = $sql->obtenerResultado("CALL sp_select_usuarios2('".$_SESSION['id_usuario_inmobiliaria']."')");
// $total_row_usuario = count($row_usuario);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Configuraciones</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nuevo configuracion</h4>
            </div>
            <div class="card-body" id="content_info">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group mt-3">
                                    <label class="control-label fw-bold">Titulo</label>
                                    <input type="text" class="form-control" id="Titulo" maxlength="50">
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group mt-3">
                                    <label class="control-label fw-bold">Descripcion</label>
                                    <textarea rows="5" type="text" class="form-control" id="Descripcion" maxlength="500"></textarea>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="text-end mt-5 pt-5 border-top">
                    <button class="btn btn-primary" id="btn_agregar_configuracion">Agregar configuracion</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL IMAGENES -->
<!-- <div class="modal fade" id="modal_img" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Recortar imagen</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm" data-id id="btn_agregar_img_blog"><i class="fa-solid fa-check me-2"></i>Recortar</button>
            </div>
        </div>
    </div>
</div> -->

<script>
    // FLATPICKR
    // $(".fecha_input").flatpickr({
    //     enableTime: true,
    //     noCalendar: false,
    //     dateFormat: "d-m-Y H:i",
    //     maxDate: "today",
    //     mode:"multiple",
    //     locale: {
    //         rangeSeparator: ' al ',
    //         firstDayOfWeek: 1,
    //         weekdays: {
    //             shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
    //             longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    //         },
    //         months: {
    //             shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
    //             longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    //         },
    //     },
    // });
    // SLIMSELECT
    // var select_id_categoria = new SlimSelect({
    //     select: '#id_categoria',
    //     searchText: 'No se encontraron resultados',
    //     searchPlaceholder: 'Buscar...',
    //     placeholder: 'Seleccione una opcion'
    // });
    // var select_id_usuario = new SlimSelect({
    //     select: '#id_usuario',
    //     searchText: 'No se encontraron resultados',
    //     searchPlaceholder: 'Buscar...',
    //     placeholder: 'Seleccione una opcion'
    // });
</script>