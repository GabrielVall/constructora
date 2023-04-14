<?php
include_once("../../../c/1/fn.php");
include_once("../../../m/SQLConexion.php");
$sql = new SQLConexion();


$row_tipo_propiedades = $sql->obtenerResultado("CALL sp_select_tipo_propiedad()");
$total_row_tipo_propiedades = count($row_tipo_propiedades);

$row_caracteristicas = $sql->obtenerResultado("CALL sp_select_caracteristicas1()");
$total_row_caracteristicas = count($row_caracteristicas);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Propiedades</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nueva propiedad <?php echo $texto_cliente; ?></h4>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <div class="nav-tabs-custom text-center">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center active" data-bs-toggle="tab" href="#tab_ubicacion" role="tab" aria-selected="true"><i class="fa-solid fa-location-dot d-block"></i>Ubicación</a>
                        </li>
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_detalles" role="tab" aria-selected="false"><i class="fa-regular fa-file-lines d-block"></i>Detalles</a>
                        </li>
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_caracteristicas" role="tab" aria-selected="false"><i class="fa-solid fa-list-ul d-block"></i>Características</a>
                        </li>
                        
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_imagenes" role="tab" aria-selected="false"><i class="fa-regular fa-images d-block"></i>Imágenes</a>
                        </li>
                    </ul>
                </div>
                <!-- Tab panes -->
                <div class="tab-content mt-5" id="tab_contenedor">
                    <!-- UBICACION -->
                    <div class="tab-pane p-3 active" id="tab_ubicacion" role="tabpanel">
                        <div id="content_direccion">
                            <div class="mb-5">
                                <label class="control-label fw-bold">Dirección</label>
                                <input id="direccion" type="text" class="form-control">
                                <input type="hidden" id="lat_direccion" value="0">
                                <input type="hidden" id="lon_direccion" value="0">
                                <div id="mapa_direccion" style="height:500px; margin: auto;"></div>
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-primary" data-tab="#tab_detalles">Siguiente</button>
                            </div>
                        </div>
                    </div>
                    <!-- DETALLES -->
                    <div class="tab-pane p-3" id="tab_detalles" role="tabpanel">
                        <!-- TIPO DE PROPIEDAD -->
                        <div class="row mb-3">
                            <label class="col-md-3 my-1 control-label fw-bold">Tipo de propiedad</label>
                            <div class="col-md-9">
                                <?php
                                for($i = 0;$i < $total_row_tipo_propiedades;$i++){
                                    echo
                                    '
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="id_tipo_propiedad_'.$row_tipo_propiedades[$i]['id_tipo_propiedad'].'" type="radio" name="id_tipo_propiedad" value="'.$row_tipo_propiedades[$i]['id_tipo_propiedad'].'">
                                        <label class="form-check-label" for="id_tipo_propiedad_'.$row_tipo_propiedades[$i]['id_tipo_propiedad'].'">'.$row_tipo_propiedades[$i]['nombre_tipo_propiedad'].'</label>
                                    </div>
                                    ';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- TIPO DE VENTA -->
                        <div class="row mb-3">
                            <label class="col-md-3 my-1 control-label fw-bold">Tipo de venta</label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="id_tipo_venta_1" type="radio" name="id_tipo_venta" value="1">
                                    <label class="form-check-label" for="id_tipo_venta_1">Venta</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="id_tipo_venta_2" type="radio" name="id_tipo_venta" value="2">
                                    <label class="form-check-label" for="id_tipo_venta_2">Renta</label>
                                </div>
                            </div>
                        </div>
                        <!-- DESCRIPCIÓN -->
                        <div class="form-group mb-3">
                            <label class="control-label fw-bold">Descripción</label>
                            <textarea id="descripcion" rows="7" class="form-control required" maxlength="1000"></textarea>
                        </div>
                        <!-- PRECIO Y MTS -->
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label fw-bold">Mts²</label>
                                    <input type="text" class="form-control sm:mt-0 form-number required format-number" id="mts" placeholder="Mts²">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label fw-bold">Precio</label>
                                    <input type="text" class="form-control form-number required format-price" id="precio" placeholder="$0.00">
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-5 pt-5 border-top">
                            <button class="btn btn-outline-primary" data-tab="#tab_ubicacion">Atrás</button>
                            <button class="btn btn-primary" data-tab="#tab_caracteristicas">Siguiente</button>
                        </div>
                    </div>
                    <!-- CARACTERISTICAS -->
                    <div class="tab-pane p-3" id="tab_caracteristicas" role="tabpanel">
                        <?php
                        for ($i = 0; $i < $total_row_caracteristicas; $i++) {
                            echo
                            '<div class="row mb-3">
                                <label class="col-md-3 my-1 control-label">' . $row_caracteristicas[$i]['nombre_caracteristica'] . '</label>
                                <div class="col-md-9 d-flex align-items-center">
                                    <div class="form-check form-switch me-3">
                                        <input class="form-check-input check_caracteristica_propiedad" id="check_caracteristica_'.$i.'" data-tipo="' . $row_caracteristicas[$i]['tipo_caracteristica'] . '" data-id="' . $row_caracteristicas[$i]['id_caracteristica'] . '" type="checkbox">
                                        <label class="form-check-label" for="check_caracteristica_'.$i.'">No</label>
                                    </div>';
                                    if ($row_caracteristicas[$i]['tipo_caracteristica'] == 2) {
                                        echo
                                        '<div class="disabledevent">
                                            <input type="text" class="form-control w-50" placeholder="0">
                                        </div>';
                                    }
                                echo
                                '</div>
                            </div>';
                        }
                        ?>
                        <div class="text-end mt-5 pt-5 border-top">
                            <button class="btn btn-outline-primary" data-tab="#tab_detalles">Atrás</button>
                            <button class="btn btn-primary" data-tab="#tab_imagenes">Siguiente</button>
                        </div>
                    </div>
                    
                    <!-- IMAGENES -->
                    <div class="tab-pane p-3" id="tab_imagenes" role="tabpanel">
                        <div class="text-end mb-3">
                            <a href="javascript:void(0);" class="ml-auto">
                                <label for="file_img_propiedad" class="text-primary btn btn-sm btn-soft-primary font-bold"><i class="fa-solid fa-plus mr-2"></i>Añadir imágenes</label>
                            </a>
                            <input type="file" class="d-none" accept="image/png, image/jpeg" id="file_img_propiedad">
                        </div>
                        <div class="alert alert-warning alert-dismissible mb-5" role="alert">El formato de imagen es .jpg .jpeg .png y un tamaño mínimo de <span class="fw-bold">800 x 800 píxeles</span>.</div>
                        <div class="row" id="content_imagenes"></div>
                        <div class="text-end mt-5 pt-5 border-top">
                            <button class="btn btn-outline-primary" data-tab="#tab_caracteristicas">Atrás</button>
                            <button class="btn btn-primary" id="btn_agregar_propiedad">Agregar propiedad</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODALES -->
<!-- IMÁGENES -->
<div class="modal fade" id="modal_img" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Recortar imagen</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm" data-id id="btn_agregar_img_propiedad"><i class="fa-solid fa-check me-2"></i>Recortar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrc4t-zWOMoqOfuh1C0yP9TrF2IFDUijc&libraries=places&callback=create_map" async defer></script>
<script>
    // MAPAS
    var place_map = "";

    function create_map() {
        var map = new google.maps.Map(document.getElementById('mapa_direccion'), {
            center: {
                lat: 28.6916213,
                lng: -100.5185625
            },
            zoom: 15,
            disableDefaultUI: true,
            streetViewControl: false,
            mapTypeControl: false,
        });
        var input_map = document.getElementById('direccion');
        var autocomplete = new google.maps.places.Autocomplete(input_map);
        autocomplete.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
        });
        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            place_map = autocomplete.getPlace();
            if (!place_map.geometry) {
                window.alert("Por favor, asegurate de utilizar el autocompletado");
                return;
            }
            if (place_map.geometry.viewport) {
                map.fitBounds(place_map.geometry.viewport);
            } else {
                map.setCenter(place_map.geometry.location);
                map.setZoom(17);
            }
            marker.setIcon(({
                url: place_map.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));
            marker.setPosition(place_map.geometry.location);
            marker.setVisible(true);
            var address = '';
            if (place_map.address_components) {
                address = [
                    (place_map.address_components[0] && place_map.address_components[0].short_name || ''),
                    (place_map.address_components[1] && place_map.address_components[1].short_name || ''),
                    (place_map.address_components[2] && place_map.address_components[2].short_name || '')
                ].join(' ');
            }
            infowindow.setContent('Punto central: <div><strong>' + place_map.name + '</strong><br>' + address);
            infowindow.open(map, marker);
            document.getElementById('lat_direccion').value = place_map.geometry.location.lat();
            document.getElementById('lon_direccion').value = place_map.geometry.location.lng();
        });
    }
</script>