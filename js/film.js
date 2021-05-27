const buttonElement = document.querySelector("#search");
const searchText = document.querySelector("#searchText");

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
      // prende tuitti i generi e ne crea una stringa 
      for (i = 0; i < movie.genres.length; i++) {
        genres += movie.genres[i].name + ' ';
      }
      let compagnia= movie.production_companies[0].name;
      let output = `
      <div class="row">
        <div class="col-md-4">
          <img src="${imageUrl + data.poster_path}" class="img-fluid">
        </div>
        <div class="col-md-8">
          <h2>${movie.title}</h2>
          <ul class="list-group">
            <li class="list-group-item"><strong>Generi:</strong> ${genres}</li>
            <li class="list-group-item"><strong>Data di rilascio:</strong> ${movie.release_date}</li>
            <li class="list-group-item"><strong>Indice Popolarita' TMDB:</strong> ${movie.popularity}</li>
            <li class="list-group-item"><strong>Budget:</strong> ${movie.budget} $</li>
            <li class="list-group-item"><strong>Compagnia principale:</strong> ${compagnia}</li>
            <li class="list-group-item"><strong>Link IMDB:</strong> <a href="https://www.imdb.com/title/${movie.imdb_id}">${movie.title}</a></li>

          </ul>
        </div>
      </div>
      <div class="card trama my-5">
        <h3 class="card-title">Trama</h3>
        <div class="card-text">${movie.overview}</div>
      </div>

      <div class="buttons mb-3">  
        <button type="button" class="btn btn-primary md-2 mb-2 mostraTrailer" onclick="hideShowTrailers()">Mostra/Nascondi trailer</button>  
        <button type="button" id="recensioneModal" class="btn btn-primary  recensioneModal mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Scrivi una recensione</button>        
          
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
  iframeContainer.setAttribute('id', 'trailers');
  iframeContainer.setAttribute('style', 'display:none');
  iframeContainer.setAttribute('class', 'trailers');

  for (let i = 0; i < length; i++) {
    const video = videos[i] // singolo video
    const iframe = createIframe(video);
    iframeContainer.appendChild(iframe);
    content.appendChild(iframeContainer);
  }
}

function hideShowTrailers() {
  var trailer = document.getElementById("trailers")
  trailer.style.display = trailer.style.display == "none" ? "flex" : "none";
};

function hideShowReview() {
  var review = document.getElementById("write_review")
  
  review.style.display = review.style.display == "none" ? "flex" : "none";
};

function getTrailer() {
  const movieId = sessionStorage.getItem('movieId');
  const path = `/movie/${movieId}/videos`
  const url = generateUrl(path);
  //fetch trailers of movies
  fetch(url)
    .then((res) => res.json())
    .then((data) => createVideoTemplate(data, containerTrailer)

    )
    .catch((error) => {
      console.log("Error: ", error);
    });
}
