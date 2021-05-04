function getMovie() {
  const movieId = sessionStorage.getItem('movieId');
  //  searchInfoMovie(movieId);
  const path = '/movie/' + movieId;
  const url = generateUrl(path); //generat path con id e api alla fine
  // console.log('Ultimo:' ,url);
  fetch(url)
    .then((res) => res.json())
    .then((data) => {
      const movie = data;
      let genres = '';
      console.log(typeof movie.genres[0].name);

      // prende tuitti i generi e ne crea una stringa 
      for (i = 0; i < movie.genres.length; i++) {
        genres += movie.genres[i].name+' ';

      }
      // movie.genres.forEach(element => {
      //   genres+'ciao';
      //   console.log('ciao');
      // });
      let output = `
      <div class="row">
        <div class="col-md-4">
          <img src="${imageUrl + data.poster_path}" class="thumbnail">
        </div>
        <div class="col-md-8">
          <h2>${movie.title}</h2>
          <ul class="list-group">
            <li class="list-group-item"><strong>Genre:</strong> ${genres}</li>
            <li class="list-group-item"><strong>Released:</strong> ${movie.release_date}</li>
            <li class="list-group-item"><strong>Rated:</strong> ${movie.Rated}</li>
            <li class="list-group-item"><strong>IMDB Rating:</strong> ${movie.imdbRating}</li>
            <li class="list-group-item"><strong>Director:</strong> ${movie.Director}</li>
            <li class="list-group-item"><strong>Writer:</strong> ${movie.Writer}</li>
            <li class="list-group-item"><strong>Actors:</strong> ${movie.Actors}</li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="well">
          <h3>Trama</h3>
          ${movie.overview}
          <hr>
          
          <a href="index.html" class="btn btn-warning">Torna Indietro</a>
        </div>
      </div>
    `;
      $('#movie').html(output);
    })
    .catch((err) => { console.log(err); });


}

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
  // console.log('data:', data.id);

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

// document.onclick = function (event) {
//   const target = event.target;
//   if (target.tagName.toLowerCase() === 'img') {
//     const movieId = target.dataset.movieId;
//     console.log('MovieID:', movieId);
//     const section = event.target.parentElement;
//     const content = section.nextElementSibling;
//     content.classList.add('content-display')
function getTrailer() {
  const movieId = sessionStorage.getItem('movieId');
  const path = `/movie/${movieId}/videos`
  const url = generateUrl(path);
  //fetch trailers of movies
  fetch(url)
    .then((res) => res.json())
    .then((data) => createVideoTemplate(data, trailer)

    )
    .catch((error) => {
      console.log("Error: ", error);
    });
}

