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
  return movies.map((movie) => {
    if (movie.poster_path) {
      return `<img src=${imageUrl + movie.poster_path} data-movie-id=${movie.id}/>`;
    }
  })
}

function createMovieContainer(movies, title = '') {
  const movieElement = document.createElement('div');
  movieElement.setAttribute('class', 'movie');

  const movietemplate = `
  <h2>${title}</h2>
    <section class="section">
    ${movieSection(movies)}
    </section>
    <div class= "content ">
      <p id="content-close">ⓧ</p>
      </div>`;
  movieElement.innerHTML = movietemplate;
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
  const movieBlock = createMovieContainer(movies,this.title);
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
