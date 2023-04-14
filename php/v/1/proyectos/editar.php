<?php 
session_start();
include_once("../../../c/1/fn.php");
include_once("../../../m/SQLConexion.php");
$sql = new SQLConexion();

$row_tipo_propiedades = $sql->obtenerResultado("CALL sp_select_tipo_propiedad()");
$total_row_tipo_propiedades = count($row_tipo_propiedades);

$row_proyecto = $sql->obtenerResultado("CALL sp_select_proyecto1('".$_POST['id_proyecto']."')");

$imagenes_nombre_proyecto = search_files(4, 'img', 'proyectos', $_POST['id_proyecto'], 1);
$imagenes_extension_proyecto = search_files(4, 'img', 'proyectos', $_POST['id_proyecto'], 3);
$imagenes_proyecto = search_files(4, 'img', 'proyectos', $_POST['id_proyecto'], 4);
$total_imagenes = count($imagenes_proyecto);

$link = $row_proyecto[0]['url_video'];
preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match);
$codigo_video = $match[1];

$tipo = $link == null ? 1 : 2;

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Proyectos</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nuevo Proyecto</h4>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <div class="nav-tabs-custom text-center">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center active" data-bs-toggle="tab" href="#tab_ubicacion" role="tab" aria-selected="true"><i class="fa-solid fa-location-dot d-block"></i>Ubicación</a>
                        </li>
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_detalles" role="tab" aria-selected="false"><i class="fa-solid fa-list-ul d-block"></i>Detalles</a>
                        </li>
                        
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_media" role="tab" aria-selected="false"><i class="fa-regular fa-images d-block"></i>Media</a>
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
                                <input id="direccion" type="text" class="form-control" value="<?php echo $row_proyecto[0]['direccion_proyecto']; ?>">
                                <input type="hidden" id="lat_direccion" value="<?php echo $row_proyecto[0]['latitud_proyecto']; ?>">
                                <input type="hidden" id="lon_direccion" value="<?php echo $row_proyecto[0]['longitud_proyecto'] ?>">
                                <div id="mapa_direccion" style="height:500px; margin: auto;"></div>
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                
                                <button class="btn btn-primary" data-tab="#tab_detalles">Siguiente</button>
                            </div>
                        </div>
                    </div>
                    <!-- DETALLES -->
                    <div class="tab-pane p-3" id="tab_detalles" role="tabpanel">
                        <div class="row">
                            <!-- TIPO DE PROPIEDAD -->
                            <div class="row mt-5 mb-3">
                                <label class="col-md-3 my-1 control-label fw-bold">Tipo de propiedad</label>
                                <div class="col-md-9">
                                    <?php
                                    for($i = 0;$i < $total_row_tipo_propiedades;$i++){
                                        $checked = $row_proyecto[0]['id_tipo_propiedad'] == $row_tipo_propiedades[$i]['id_tipo_propiedad'] ? 'checked' : '';
                                        echo
                                        '
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" id="id_tipo_propiedad_'.$row_tipo_propiedades[$i]['id_tipo_propiedad'].'" type="radio" name="id_tipo_propiedad" value="'.$row_tipo_propiedades[$i]['id_tipo_propiedad'].'" '.$checked.'>
                                            <label class="form-check-label" for="id_tipo_propiedad_'.$row_tipo_propiedades[$i]['id_tipo_propiedad'].'">'.$row_tipo_propiedades[$i]['nombre_tipo_propiedad'].'</label>
                                        </div>
                                        ';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label class="control-label fw-bold">Descripcion</label>
                                    <textarea rows="4" type="text" class="form-control" id="descripcion" maxlength="1000"><?php echo $row_proyecto[0]['descripcion_proyecto']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mt-3">
                                    <label class="control-label fw-bold">Mts²</label>
                                    <input type="text" class="form-control sm:mt-0 form-number required format-number" id="metros_cuadrados" placeholder="Mts²" value="<?php echo $row_proyecto[0]['mts_proyecto']; ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mt-3">
                                    <label class="control-label fw-bold">Precio</label>
                                    <input type="text" class="form-control form-number required format-price" id="precio" placeholder="$0.00" value="<?php echo $row_proyecto[0]['precio_proyecto']; ?>">
                                </div>
                            </div>
                            
                            
                            
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-outline-primary" data-tab="#tab_ubicacion">Atrás</button>
                                <a id="id_media2" class="btn btn-primary">Siguiente</a>
                            </div>
                        </div>
                    </div>
                                                      
                    <!-- MEDIA -->
                    <div class="tab-pane p-3" id="tab_media" role="tabpanel" data-active-media="<?php echo $tipo; ?>">
                        <div class="text-end mb-3">
                            <!-- Nav tabs -->
                            <div class="nav-tabs-custom text-center">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item media">
                                        <a style="padding: 10px 25px;" tipo_media="1" id="media_imagenes" class="nav-link text-center" data-bs-toggle="tab" href="#tab_imagenes_proyecto" role="tab" aria-selected="true"><i class="fas fa-image d-block"></i>Imagenes</a>
                                    </li>
                                    <li class="nav-item media">
                                        <a style="padding: 10px 25px;" tipo_media="2" id="media_videos" class="nav-link text-center" data-bs-toggle="tab" href="#tab_videos" role="tab"aria-selected="true" ><i class="fab fa-youtube d-block"></i>Video</a>
                                    </li>                                                
                                </ul>
                            </div>

                        </div>
                        <div class="alert alert-warning alert-dismissible mb-5" role="alert">Por favor seleccione si desea utilizar imagenes hasta un maximo de 9 o si desea utilizar un video de youtube respectivamente.
                            <span class="fw-bold">Nota: Solamente podra utilizar una opcion a la vez</span>.
                        </div>
                        <div class="text-end mt-5 pt-5 border-top">
                        <button class="btn btn-outline-primary" data-tab="#tab_detalles">Atrás</button>
                        <button class="btn btn-primary" id="btn_guardar_proyecto" data-id="<?php echo $_POST['id_proyecto']; ?>">Guardar proyecto</button>
                        </div>
                    </div>    
                    
                    <!-- IMAGENES -->
                    <div class="tab-pane p-3" id="tab_imagenes_proyecto" role="tabpanel">
                        <div class="text-end mb-3">
                            <a href="javascript:void(0);" style="float:left;" class="ml-auto">
                                <label id="cancelar_media" class="text-primary btn btn-sm btn-soft-danger font-bold"><i class="fa-solid fa-arrow-left mr-2"></i>Cancelar</label>
                            </a>                                 
                             <a href="javascript:void(0);" class="ml-auto">
                                <label for="file_img_proyecto" class="text-primary btn btn-sm btn-soft-primary font-bold <?php echo $total_imagenes == 9 ? 'disabledevent' : ''; ?>"><i class="fa-solid fa-plus mr-2"></i>Añadir imágenes</label>
                            </a>
                            <input type="file" class="d-none" accept="image/png, image/jpeg" id="file_img_proyecto">

                        </div>
                        <div class="alert alert-warning alert-dismissible mb-5" role="alert">El formato de imagen es .jpg .jpeg .png y un tamaño mínimo de <span class="fw-bold">800 x 800 píxeles</span>.</div>
                        <div class="row" id="content_imagenes">
                        <?php 
                        if($total_imagenes > 0){
                            for($i = 0;$i < $total_imagenes; $i++) {
                                echo 
                                '
                                <div class="col-12 col-md-6 col-lg-4 img-prev" data-id="'.$i.'">
                                    <div class="card border">
                                        <a href="'.$imagenes_proyecto[$i].'" data-fancybox="gallery">
                                            <img class="card-img-top img-fluid bg-light-alt" data-id="1" data-formato="'.$imagenes_extension_proyecto[$i].'" src="'.$imagenes_proyecto[$i].'">
                                        </a>
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col">                      
                                                    <h6 class="card-title">'.$imagenes_nombre_proyecto[$i].'</h6>               
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-end">
                                            <a href="javascript:void(0);" id="eliminar_img_prev_proyecto" data-id="'.$i.'" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                        }
                            
                        ?>                      
                        </div>
                        <div class="text-end mt-5 pt-5 border-top">
                            <button class="btn btn-outline-primary" data-tab="#tab_detalles">Atrás</button>
                            <button class="btn btn-primary" id="btn_guardar_proyecto" data-id="<?php echo $_POST['id_proyecto']; ?>">Guardar proyecto</button>
                        </div>
                    </div>

                    <!-- VIDEOS -->
                    <div class="tab-pane p-3" id="tab_videos" role="tabpanel">
                        <div class="row mb-3">
                            <a href="javascript:void(0);" style="float:left;" class="ml-auto mb-3">
                                <label id="cancelar_media" class="text-primary btn btn-sm btn-soft-danger font-bold"><i class="fa-solid fa-arrow-left mr-2"></i>Cancelar</label>
                            </a>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label class="control-label fw-bold">URL</label>
                                    <input type="text" class="form-control format-string" id="url_youtube">
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <a href="javascript:void(0);" class="ml-auto">
                                <label id="agregar_video" class="text-primary btn btn-soft-primary font-bold disabledevent" ><i class="fa-solid fa-plus mr-2"></i>Añadir video</label>
                            </a>
                        </div>
                        <div class="alert alert-warning alert-dismissible mb-5" role="alert">Por favor utilice solamente links de videos de <span class="fw-bold">youtube</span>.</div>
                        <div class="row" id="content_videos">
                        <?php 
                        if(strlen($link) > 0){
                            echo 
                            '
                            <div class="border vid-prev" data-id="0">
                                <div class="card-body">
                                    <div class="ratio ratio-21x9">
                                        <iframe src="https://www.youtube.com/embed/'.$codigo_video.'?rel=0&modestbranding=1&listType=playlist&showinfo=0&iv_load_policy=3" data-url-og="'.$link.'" title="YouTube video" allowfullscreen></iframe>
                                    </div>                                  
                                </div>
                                <div class="card-body text-end">
                                    <a href="javascript:void(0);" id="eliminar_prev_videos" data-id="0" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
                                </div>
                            </div>
                            ';
                        }
                        ?>
                        </div>
                        <div class="text-end mt-5 pt-5 border-top">
                            <button class="btn btn-outline-primary" data-tab="#tab_detalles">Atrás</button>
                            <button class="btn btn-primary" id="btn_guardar_proyecto" data-id="<?php echo $_POST['id_proyecto']; ?>">Guardar proyecto</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
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
                <button type="button" class="btn btn-primary btn-sm" data-id id="btn_agregar_img_proyecto"><i class="fa-solid fa-check me-2"></i>Recortar</button>
            </div>
        </div>
    </div>
</div>
<!-- VIDEOS -->
<div class="modal fade" id="modal_videos" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Previsualizacion de video</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body "></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm" data-id id="btn_agregar_video"><i class="fa-solid fa-check me-2"></i>Agregar</button>
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