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
                <a refnav="propiedad?id=${objeto.id_propiedad}" class="btn btn-primary btn-block w-100 moreinfo">Más información</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
        }
        $("#prop_html").html(html);
      })
      .fail(function (error) {
        console.error(error);
      });
  }

  function initSwiper() {
    const swiper = new Swiper(".swiper", {
      loop: true,
      spaceBetween: 20,
      slidesPerView: "auto",
      centeredSlides: true,
      pagination: {
        el: ".swiper-pagination",
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
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
          'url("img/' + data.ruta_imagen + '")'
        );
        results.forEach((result) => {
          const nombreConfiguracion = result.nombre_configuracion;
          const descripcionConfiguracion = result.descripcion_configuracion;
          const elemento = document.querySelector(`[${nombreConfiguracion}]`);
          if (elemento) {
            // Check if elemento exists
            if (nombreConfiguracion.includes("url")) {
              elemento.setAttribute("externalref", descripcionConfiguracion);
            } else {
              elemento.innerHTML = descripcionConfiguracion;
            }
          }
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

    async ejecutar() {
      const nombrePagina = this.urlHandler.getCurrentUrl();
      const funcion =
        this.paginaFunciones[nombrePagina] || this.paginaFunciones.index;
      await funcion();
      // Llama a la función en cada página
      global();
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

  const urlHandler = new URLHandler(MAIN_URL);
  const paginaFunciones = new PaginaFunciones();
  const paginaActual = new Pagina(urlHandler, paginaFunciones);
  paginaActual.ejecutar();
});
