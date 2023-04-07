function getViews(fileUrls) {
  return Promise.all(fileUrls.map((fileUrl) => {
    return fetch(`http://localhost/proyectos/constructora/app/view/${fileUrl}.html`).then((response) => {
      return response.text();
    });
  })).then((results) => {
    return results.join('');
  });
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
  index() {
    getViews(['nav','banner','why-us','details','slider-clients','contact-banner','our-clients','bottom-banner','footer']).then(setMainContent);
  }

  propiedades() {
    getViews(['nav','top-page','footer']).then((html) => {
      setMainContent(html);
      cambiarFondo();
    });
  }

  propiedad() {
    getViews(['nav','propiedad','footer']).then((html) => {
      setMainContent(html);
      cambiarFondo();
      initSwiper();
    });
  }
}

class Pagina {
  constructor(urlHandler, paginaFunciones) {
    this.urlHandler = urlHandler;
    this.paginaFunciones = paginaFunciones;
  }

  ejecutar() {
    const nombrePagina = this.urlHandler.getCurrentUrl();
    const funcion = this.paginaFunciones[nombrePagina] || this.paginaFunciones.index;
    funcion();
  }
}

const urlHandler = new URLHandler('http://localhost/proyectos/constructora/');
const paginaFunciones = new PaginaFunciones();
const paginaActual = new Pagina(urlHandler, paginaFunciones);
paginaActual.ejecutar();
