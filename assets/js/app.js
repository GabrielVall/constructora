async function getViews(fileUrls) {
  try {
    const responses = await Promise.all(fileUrls.map((fileUrl) => {
      return fetch(`http://localhost/proyectos/constructora/app/view/${fileUrl}.html`);
    }));
    const texts = await Promise.all(responses.map(response => response.text()));
    return texts.join('');
  } catch (error) {
    console.error(error);
    // Devolver una respuesta de error en formato JSON
    const errorResponse = {
      message: 'Error de la base de datos',
      details: error.message
    };
    throw errorResponse;
  }
}

function setMainContent(html) {
  document.getElementById('main').innerHTML = html;
}

function cambiarFondo() {
  const bg = document.querySelector('.bg-transparent');
  bg.classList.remove('bg-transparent');
  bg.classList.add('bg-dark');
}

function initSwiper() {
  const swiper = new Swiper('.swiper', {
    loop: true,
    spaceBetween: 20,
    slidesPerView: 'auto',
    centeredSlides: true,
    pagination: {
      el: '.swiper-pagination',
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
}
function global(){
  fetch('http://localhost/proyectos/constructora/app/controller/configuracion.php')
  .then(response => response.json())
  .then(data => {
    const results = data.result;
    results.forEach(result => {
      const nombreConfiguracion = result.nombre_configuracion;
      const descripcionConfiguracion = result.descripcion_configuracion;
      const elemento = document.querySelector(`[${nombreConfiguracion}]`);
      if (elemento) { // Check if elemento exists
        if (nombreConfiguracion.includes("url")) {
          elemento.setAttribute("externalref", descripcionConfiguracion);
        } else {
          elemento.innerHTML = descripcionConfiguracion;
        }
      }
    });
     // Seleccionar todos los elementos con la clase "refnav"
  const refnavElements = document.querySelectorAll('[refnav]');
  // Iterar sobre los elementos y añadirles un event listener al hacer click
  refnavElements.forEach((element) => {
    element.addEventListener('click', () => {
      // Obtener el valor del atributo "data-link" del elemento
      const link = element.getAttribute('refnav');
  
      // Si el valor del atributo no está vacío, concatenar el valor a la URL
      // de lo contrario, utilizar solo la URL base
      const url = link ? `http://localhost/proyectos/constructora/${link}` : 'http://localhost/proyectos/constructora/';
  
      // Redireccionar a la URL
      window.location.href = url;
    });
  });

  // Select all elements with the "externalref" attribute
  const externalRefs = document.querySelectorAll("[externalref]");

  // Add a click event listener to each element
  externalRefs.forEach(elem => {
    elem.addEventListener("click", () => {
      // Get the URL from the "externalref" attribute
      const url = elem.getAttribute("externalref");

      // Redirect to the URL
      window.open(url, '_blank');
    });
  });

  })
  .catch(error => console.error(error));

}
class URLHandler {
  constructor(mainUrl) {
    this.mainUrl = mainUrl;
  }

  getCurrentUrl() {
    let current = window.location.href.replace(this.mainUrl, '');
    current = current.split('?')[0]; // Elimina todo lo que viene después del símbolo '?'
    return current === '' ? 'index' : current;
  }
  
}

class PaginaFunciones {
  async index() {
    const html = await getViews(['nav','banner','why-us','details','slider-clients','contact-banner','our-clients','bottom-banner','footer']);
    setMainContent(html);
  }

  async propiedades() {
    const html = await getViews(['nav','top-page','footer']);
    setMainContent(html);
    cambiarFondo();
  }

  async propiedad() {
    const html = await getViews(['nav','propiedad','footer']);
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
    const funcion = this.paginaFunciones[nombrePagina] || this.paginaFunciones.index;
    await funcion();
    // Llama a la función en cada página
    global();
  }
}

const urlHandler = new URLHandler('http://localhost/proyectos/constructora/');
const paginaFunciones = new PaginaFunciones();
const paginaActual = new Pagina(urlHandler, paginaFunciones);
paginaActual.ejecutar();
