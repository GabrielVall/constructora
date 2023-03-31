function getViews(fileUrls){
    let concatenatedResult = "";

    fileUrls.forEach((fileUrl) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", 'http://localhost/proyectos/constructora/app/view/'+fileUrl+'.html', false);
        xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            concatenatedResult += xhr.responseText;
        }
        };
        xhr.send();
    });
  document.getElementById('main').innerHTML = concatenatedResult;
}
// Archivo url.js
class URLHandler {
  constructor(mainUrl) {
    this.mainUrl = mainUrl;
  }
  getCurrentUrl() {
    const current = window.location.href.replace(this.mainUrl, "");
    return current === "" ? "index" : current;
  }
}

// Archivo funciones.js
class PaginaFunciones {
  index() {
    getViews(['nav','banner','why-us','details','slider-clients','contact-banner','our-clients','bottom-banner','footer']);
  }
  propiedades() {
    getViews(['nav','top-page','footer']);
  }
}

// Archivo pagina.js
class Pagina {
  constructor(urlHandler, paginaFunciones) {
    this.urlHandler = urlHandler;
    this.paginaFunciones = paginaFunciones;
  }
  ejecutar() {
    const nombrePagina = this.urlHandler.getCurrentUrl();
    const funcion = this.paginaFunciones[nombrePagina];
    if (funcion) {
      funcion();
    }
  }
}

// Archivo app.js
const urlHandler = new URLHandler("http://localhost/proyectos/constructora/");
const paginaFunciones = new PaginaFunciones();
const paginaActual = new Pagina(urlHandler, paginaFunciones);
paginaActual.ejecutar();
