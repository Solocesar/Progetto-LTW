// Prendere elementi dal DOM

const buttonElement = document.querySelector("#search");
const searchText = document.querySelector("#searchText");
const ContenitoreFilm = document.querySelector("#ContenitoreFilm");
const popularMovies = document.querySelector("#popularMovies");





function handleError() {
  console.log(error);
}




// sezione di un singolo film
function movieSection(movies) {
  const section = document.createElement('section');
  section.classList = 'section';
  movies.map((movie) => {
    const img = document.createElement('img');
    img.src = imageUrl + movie.poster_path;
    // img['data-movie-id'] = imageUrl + movie.poster_path;
    img.setAttribute('data-movie-id',movie.id);

    section.appendChild(img);

  })
  return section;
}

function createMovieContainer(movies, title = '') {

  const movieElement = document.createElement('div');
  movieElement.setAttribute('class', 'movie');

  //crea la sezione per il titolo 
  const header = document.createElement('h2');
  header.innerHTML = title;

  const content = document.createElement('div');
  content.classList = 'content';

  const contentClose = `<p id="content-close">X</p>`;

  content.innerHTML = contentClose;

  const section = movieSection(movies);

  movieElement.appendChild(header);
  movieElement.appendChild(section);
  movieElement.appendChild(content);
  return movieElement;
}

function renderSearchMovies(data) {
  // array dei film 
  ContenitoreFilm.innerHTML = '';  // pulisce il container dei film 
  const movies = data.results;
  const movieBlock = createMovieContainer(movies);
  ContenitoreFilm.appendChild(movieBlock);
  console.log("Data: ", data);
}

// per i film popolari ,in arrivo , ecc
function renderMovies(data) {
  // array dei film 
  const movies = data.results;
  const movieBlock = createMovieContainer(movies, this.title);
  popularMovies.appendChild(movieBlock);
}

buttonElement.onclick = function (event) {
  event.preventDefault();
  const value = searchText.value;
  searchMovie(value);

  searchText.value = '';
  console.log("Value:", value);
};

// create iframe
function createIframe(video) {
  const iframe = document.createElement('iframe');
  iframe.src = `https://www.youtube.com/embed/${video.key}`
  iframe.width = 360;
  iframe.height = 315;
  iframe.allowFullscreen = true;
  return iframe;
}
// create video template
function createVideoTemplate(data, content) {
  content.innerHTML = '<p id="content-close">X</p>'
  const videos = data.results;
  const length = videos.length > 4 ? 4 : videos.length; // lunghezza video 
  const iframeContainer = document.createElement('div');

  for (let i = 0; i < length; i++) {
    const video = videos[i] // singolo video
    const iframe = createIframe(video);
    iframeContainer.appendChild(iframe);
    content.appendChild(iframeContainer);
  }
}
// Event delegation
// click in qualunque  parte del documento e se il target e' un img

document.onclick = function (event) {
  const target = event.target;
  if (target.tagName.toLowerCase() === 'img') {
    const movieId = target.dataset.movieId;
    console.log('MovieID:', movieId);
    const section = event.target.parentElement;
    const content = section.nextElementSibling;
    content.classList.add('content-display')

    const path = `/movie/${movieId}/videos`
    const url = generateUrl(path);
    //fetch movies
    fetch(url)
      .then((res) => res.json())
      .then((data) => createVideoTemplate(data, content)

      )
      .catch((error) => {
        console.log("Error: ", error);
      });
  }
  console.log(target.tagName);
  if (target.id === 'content-close') {
    const content = target.parentElement;
    content.classList.remove('content-display');
    console.log('click');
  }

}

searchUpcomingMovies();
searchPopularMovies();
