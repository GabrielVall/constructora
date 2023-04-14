$(function () {
  const MAIN_URL = `https://bexpress.mx/proyectos/constructora/`;
  $(document).on("click", "[refnav]", function () {
    // Obtener el valor del atributo "refnav" del elemento
    const link = $(this).attr("refnav");

    // Si el valor del atributo no está vacío, concatenar el valor a la URL
    // de lo contrario, utilizar solo la URL base
    const url = link ? `${MAIN_URL}${link}` : MAIN_URL;

    // Redireccionar a la URL
    window.location.href = url;
  });

  async function getViews(fileUrls) {
    try {
      const responses = await Promise.all(
        fileUrls.map((fileUrl) => {
          return fetch(`${MAIN_URL}app/view/${fileUrl}.html`);
        })
      );
      const texts = await Promise.all(
        responses.map((response) => response.text())
      );
      return texts.join("");
    } catch (error) {
      console.error(error);
      // Devolver una respuesta de error en formato JSON
      const errorResponse = {
        message: "Error de la base de datos",
        details: error.message,
      };
      throw errorResponse;
    }
  }

  function setMainContent(html) {
    document.getElementById("main").innerHTML = html;
  }

  function cambiarFondo() {
    const bg = document.querySelector(".bg-transparent");
    bg.classList.remove("bg-transparent");
    bg.classList.add("bg-dark");
  }
  function generarParamsUrl(params) {
    const paramKeys = Object.keys(params);
    const paramValues = Object.values(params);
    let urlParams = "";

    for (let i = 0; i < paramKeys.length; i++) {
      if (paramValues[i]) {
        urlParams += `${paramKeys[i]}=${paramValues[i]}&`;
      }
    }

    return urlParams.slice(0, -1);
  }

  function buscar(predefinied = 0) {
    console.log(predefinied);
    let search = $(".busqueda_input").val();
    let tipo = $('[name="tipo_venta"]:checked').val();
    let tipo_prop = $('[name="tipo_prop"]:checked').val();
    min = $("#minPrice").val();
    max = $("#maxPrice").val();
    minArea = $("#area_minima").val();
    maxArea = $("#area_maxima").val();
    if (predefinied == "comprar") {
      $('[value="1"][name="tipo_venta"]').prop("checked", true);
      tipo = 1;
    }
    if (predefinied == "rentar") {
      $('[value="2"][name="tipo_venta"]').prop("checked", true);
      tipo = 2;
    }
    let params = {
      min_precio: min,
      max_precio: max,
      min_mts: minArea,
      max_mts: maxArea,
      id_tipo_propiedad: tipo_prop,
      id_tipo_venta: tipo,
      busqueda: search,
    };
    console.log(tipo);
    let urlParams = generarParamsUrl(params);
    $.ajax({
      url: `${MAIN_URL}app/controller/propiedades.php?` + urlParams,
      method: "GET",
      dataType: "json",
    })
      .done(function (data) {
        objetos = data.result;
        $("#resultados").html(
          `Mostrando 1-${data.row_count} de ${data.row_count} resultados`
        );
        $("#total_results").html(
          `Cerca de ${data.row_count} resultados (${data.execution_time.value} segundos)`
        );
        html = "";
        for (let objeto of objetos) {
          html += `
    <div class="col-12 mb-4">
        <div class="card">
          <div class="row d-flex align-items-center">
            <div class="col-md-5">
              <img src="${MAIN_URL}img/propiedades/${objeto.ruta_imagen}" class="card-img" alt="Imagen">
            </div>
            <div class="col-md-7">
              <div class="card-body d-flex justify-content-between pb-0">
                <p class="card-text renta">Renta</p>
                <p class="card-text renta precio">$34,000/Mes</p>
              </div>
              <div class="card-body">
                <h5 class="card-title bold24">${objeto.descripcion_propiedad}</h5>
                <p class="card-text"><svg width="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path></svg> ${objeto.direccion_propiedad}</p>
                <a refnav="propiedad?target=${objeto.id_propiedad}" class="btn btn-primary btn-block w-100 moreinfo">Más información</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
  }
  $('#prop_html').html(html);
}).fail(function(error) {
  console.error(error);
});

}


function ajaxPropiedad(id){
  $.ajax({
    url: `http://localhost/proyectos/constructora/app/controller/traerPropiedad.php?id_propiedad=${id}`,
    method: 'GET',
    dataType: 'json'
  }).done(function(data) {
    propiedad = data.result;
    let ruta_imagenes_slider = propiedad[0].ruta_archivos.length;
    let total_caracteristicas = propiedad[0].caracteristicas.length;
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    let fecha_propiedad = propiedad[0].fecha_registro_formato.split("-")[0] + ' de ' + meses[parseInt(propiedad[0].fecha_registro_formato.split("-")[1]-1)] + ' del ' + propiedad[0].fecha_registro_formato.split("-")[2];
    html = '';
    html_slider = '';
    html_script = '';
    html += `
    <div class="ltn__shop-details-inner ltn__page-details-inner mb-60">
    <div class="ltn__blog-meta">
        <ul style="list-style: none;">
            <li class="ltn__blog-category" style="margin-top: 1em;">
                <a>${fecha_propiedad}</a>
            </li>
        </ul>
    </div>
    <h1 style="font-size: 3em;">Propiedad tipo ${propiedad[0].nombre_tipo_propiedad} </h1>
    <li class="d-flex list-inline-item mt-2 mt-sm-0">
                <i class=""></i>${propiedad[0].visitas} vistas
              </li>
    <label>
        <span class="ltn__secondary-color">
            <i class="flaticon-pin"></i>
        </span>
        ${propiedad[0].direccion_propiedad} 
    </label>
    <h4 class="title-2">Descripcion</h4>
    <div class="row d-flex justify-content-left">
      <p class="col-lg-6 card-text mb-1 renta precio">Precio: $${propiedad[0].precio_propiedad}/Mes</p>
      <p class="col-lg-6 card-text mb-1 renta precio">Metros cuadrados: ${propiedad[0].precio_propiedad} m²</p>
    </div>
    <p>${propiedad[0].descripcion_propiedad}.</p>
    <h4 class="title-2 mb-10">Caracteristicas</h4>
    <div class="property-details-amenities mb-60">
        <div class="row d-flex justify-content-left">
        <p class="card-text renta">Tipo: ${propiedad[0].nombre_tipo_venta}</p>
            `;
            if(total_caracteristicas !== undefined){
              for($i=0; $i<total_caracteristicas;$i++){
                html +=`
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="ltn__menu-widget">
                        <ul>
                            <li>
                                <label class="checkbox-item">${propiedad[0].caracteristicas[$i]['nombre_caracteristica']}
                                    <input type="checkbox" checked="checked">
                                    <h5 class="numero">${propiedad[0].caracteristicas[$i]['cantidad_detalle_caracteristica'] !== '0' ? propiedad[0].caracteristicas[$i]['cantidad_detalle_caracteristica'] : '-'}</h5>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                `;
              }
            }
            html +=`
        </div>
    </div>
    `;
    html +=`
    <h4 class="title-2">Localizacion</h4>
    <input id="direccion" value="${propiedad[0].direccion_propiedad}" type="text" class="form-control d-none">
    <input type="hidden" id="lat_propiedad" value="${propiedad[0].latitud_propiedad}">
    <input type="hidden" id="lon_propiedad" value="${propiedad[0].longitud_propiedad}">
    <div id="div_mapa" style="height:500px; margin: auto;">
    
    </div>
    <div class=" py-5" style="background-color: #f3f3f3;
    margin: 5em 0 5em;">
        <div class="container">
          <h2 class="text-center mb-4 title">Obtener más información</h2>
          <div id="content_info">
              <div class="mb-3">
                <label for="subject" class="form-label" style="font-size: 1.3em;font-family: bold;">Nombre</label>
                <input type="text" class="form-control" id="nombre_msg" >
              </div>
              <div class="mb-3">
                <label for="subject" class="form-label" style="font-size: 1.3em;font-family: bold;">Telefono de contacto</label>
                <input type="text" class="form-control telefono" id="telefono_msg" >
              </div>
              <div class="mb-3">
                <label for="message" class="form-label" style="font-size: 1.3em;font-family: bold;">Mensaje</label>
                <textarea class="form-control" id="mensaje_msg" name="message" rows="5"></textarea>
              </div>
              <button id="enviar_msg" class="btn btn-primary btn-lg btn-block">Enviar</button>
          </div>
        </div>
      </div>
</div>
    `;
    if(ruta_imagenes_slider !== undefined){
      for($i = 0;$i<ruta_imagenes_slider;$i++){
        html_slider +=`
        <div class="swiper-slide">
        <div class="row justify-content-center d-flex align-items-center prop-slidder slide_banner" style="background-image:url('img/propiedades/${propiedad[0].ruta_archivos[$i]}');"></div>
        </div>
        `;
      }
    }
    html_script = `
    <script>
var latitud = ${propiedad[0].latitud_propiedad};
var longitud = ${propiedad[0].longitud_propiedad} ;
var place_map = "";

function create_map() {
  var map = new google.maps.Map(document.getElementById('div_mapa'), {
      center: {
          lat: latitud,
          lng: longitud
      },
      zoom: 18,
      disableDefaultUI: true,
      streetViewControl: false,
      mapTypeControl: false,
  });
  var infowindow = new google.maps.InfoWindow({
      content: '<h6 class="text-500" style="color: #5e6e82;">Direccion</h6><p class="text-500" style="color: #5e6e82;">${propiedad[0].direccion_propiedad}</p>',
  });
  var marker = new google.maps.Marker({
      position: {
          lat: latitud,
          lng: longitud
      },
      map: map,
      anchorPoint: new google.maps.Point(0, -29),
      animation: google.maps.Animation.DROP,
  });
  infowindow.open({
      anchor: marker,
      map,
      shouldFocus: false,
  });
  marker.addListener("click", () => {
      infowindow.open({
          anchor: marker,
          map,
          shouldFocus: false,
      });
  });
}

// Carga el script de Google Maps con el callback a create_map
function addGoogleMapsScript() {
  const script = document.createElement("script");
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCrc4t-zWOMoqOfuh1C0yP9TrF2IFDUijc&libraries=places&callback=create_map";
  document.body.appendChild(script);
}

// Llama la función para cargar el script
addGoogleMapsScript();
</script>
    `;
  $("#propiedad_slider").html(html_slider);
  $("#propiedad_contenido").html(html);
  $("#script").html(html_script);
  }).fail(function(error) {
    console.error(error);
  });
}

function initSwiper() {
  const swiper = new Swiper('.swiper', {
    loop: true,
    spaceBetween: 30,
    slidesPerView: 1,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
}
function global() {
  fetch(`${MAIN_URL}app/controller/configuracion.php`)
    .then((response) => response.json())
    .then((data) => {
      const results = data.result;
      $(".jumbotron").css(
        "background-image",
        'url("img/' + data.ruta_imagen_banner + '")'
      );

      $(".seccion1img").attr('src', 'img/'+data.ruta_imagen_seccion1 );
      $(".seccion3img").attr('src', 'img/'+data.ruta_imagen_seccion3 );

      results.forEach((result) => {
        const nombreConfiguracion = result.nombre_configuracion;
        const descripcionConfiguracion = result.descripcion_configuracion;
        const elemento = document.querySelector(`[${nombreConfiguracion}]`);
        if (elemento) {
          if (nombreConfiguracion == 'correo') {
            correo = descripcionConfiguracion;
          }
          // Check if elemento exists
          if (nombreConfiguracion.includes("url")) {
            elemento.setAttribute("externalref", descripcionConfiguracion);
          } else {
            elemento.innerHTML = descripcionConfiguracion;
          }
        }
      });
      $(document).on('click', '#enviar_mail', function (event) {
        event.preventDefault();
        const email = correo;
        const tel = $('#telefono').val();
        const subject = $('#your-subject').val();
        const message = `${$('#your-message').val()}%0A%0ATeléfono de contacto: ${tel}`;
      
        if (email === '' || !validateEmail(email)) {
          alert('Por favor, introduce una dirección de correo electrónico válida.');
          return;
        }
      
        if (subject === '') {
          alert('Por favor, introduce un asunto.');
          return;
        }
      
        if (message === '') {
          alert('Por favor, introduce un mensaje.');
          return;
        }
      
        const mailtoLink = `mailto:${email}?subject=${subject}&body=${message}`;
      
        window.location.href = mailtoLink;
      });
      
      // Select all elements with the "externalref" attribute
      const externalRefs = document.querySelectorAll("[externalref]");

      // Add a click event listener to each element
      externalRefs.forEach((elem) => {
        elem.addEventListener("click", () => {
          // Get the URL from the "externalref" attribute
          const url = elem.getAttribute("externalref");

          // Redirect to the URL
          window.open(url, "_blank");
        });
      });
    })
    .catch((error) => console.error(error));
}
  class URLHandler {
    constructor(mainUrl) {
      this.mainUrl = mainUrl;
    }

    getCurrentUrl() {
      let current = window.location.href.replace(this.mainUrl, "");
      current = current.split("?")[0]; // Elimina todo lo que viene después del símbolo '?'
      return current === "" ? "index" : current;
    }
  }

  class PaginaFunciones {
    async index() {
      const html = await getViews([
        "nav",
        "banner",
        "why-us",
        "details",
        "slider-clients",
        "contact-banner",
        "our-clients",
        "bottom-banner",
        "footer",
      ]);
      setMainContent(html);
    }

    async propiedades() {
      const html = await getViews(["nav", "top-page", "footer"]);
      setMainContent(html);
      cambiarFondo();
      buscar();
    }
    async rentar() {
      const html = await getViews(["nav", "top-page", "footer"]);
      setMainContent(html);
      cambiarFondo();
      buscar("rentar");
    }
    async comprar() {
      const html = await getViews(["nav", "top-page", "footer"]);
      setMainContent(html);
      cambiarFondo();
      buscar("comprar");
    }

    async propiedad() {
      const html = await getViews(["nav", "propiedad", "footer"]);
      setMainContent(html);
      cambiarFondo();
      initSwiper();
    }
  }

  class Pagina {
    constructor(urlHandler, paginaFunciones) {
      this.urlHandler = urlHandler;
      this.paginaFunciones = paginaFunciones;
    }
  

  async propiedad() {
    const html = await getViews(['nav','propiedad','footer']);
    setMainContent(html);
    cambiarFondo();
    ajaxPropiedad(urlId());
    initSwiper();
    
  }
}
  let timeoutId;
  $(document).on(
    "input",
    '[name="tipo_venta"],[name="tipo_prop"],.propiedad_cont input',
    function () {
      $("#prop_html").html(
        `<div class="row justify-content-center d-flex mt-5">
      <span class="loader"></span>
    </div>
    <div class="row justify-content-center d-flex mt-5" style="font-size:2em; font-family: bold;">
      Buscando propiedades...
    </div>`
      );
      // Clear any previous timeouts
      clearTimeout(timeoutId);
      // Start a new timeout to call buscar() after 600ms
      timeoutId = setTimeout(buscar, 600);
    }
  );

$(document).on('click', '#enviar_msg', function(){
validar_formulario("#content_info input");
validar_formulario("#content_info textarea");
if ($("#content_info .is-invalid").length == 0) {
  var mails = 'brandonlee191218@hotmail.com';
  var nombre = $("#nombre_msg").val().trim();
  var celular = $('#telefono_msg').val().trim();
  var url = window.location.href;
  var body = $('#mensaje_msg').val()+ 
        `%0A Propiedad de interes: ${url}
        %0A Datos de contacto:
        %0A Nombre: ${nombre} 
        %0A Telefono: ${celular}`;
  window.open(`mailto:${mails}?subject=Estoy interesado en una propiedad&body=${body}`, '_blank');
}
});



function urlId(){
  let url = window.location.href;
  let parametro = new URLSearchParams(url.split('?')[1]);
  let target = parametro.get('target');
  return target;
}

class Pagina {
  constructor(urlHandler, paginaFunciones) {
    this.urlHandler = urlHandler;
    this.paginaFunciones = paginaFunciones;
  }

  async ejecutar() {
    const nombrePagina = this.urlHandler.getCurrentUrl();
    const funcion = this.paginaFunciones[nombrePagina] || this.paginaFunciones.index;
    await funcion();
    // Llama a la función en cada página
    global();
  }
}

$(document).on('click', '[name="tipo_venta"]', function() {
  buscar();
});

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

const urlHandler = new URLHandler('http://localhost/proyectos/constructora/');
const paginaFunciones = new PaginaFunciones();
const paginaActual = new Pagina(urlHandler, paginaFunciones);
paginaActual.ejecutar();
});
