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
      document.querySelector(`[${nombreConfiguracion}]`).innerHTML = descripcionConfiguracion;
    });
  })
  .catch(error => console.error(error));

}
class URLHandler {
  constructor(mainUrl) {
    this.mainUrl = mainUrl;
  }

  getCurrentUrl() {
    const current = window.location.href.replace(this.mainUrl, '');
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
