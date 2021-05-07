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
      console.log(typeof movie.genres[0].name);

      // prende tuitti i generi e ne crea una stringa 
      for (i = 0; i < movie.genres.length; i++) {
        genres += movie.genres[i].name + ' ';
      }

      let output = `
      <div class="row">
        <div class="col-md-4">
          <img src="${imageUrl + data.poster_path}" class="img-fluid">
        </div>
        <div class="col-md-8">
          <h2>${movie.title}</h2>
          <ul class="list-group">
            <li class="list-group-item"><strong>Genre:</strong> ${genres}</li>
            <li class="list-group-item"><strong>Released:</strong> ${movie.release_date}</li>
            <li class="list-group-item"><strong>Popular index:</strong> ${movie.popularity}</li>

          </ul>
        </div>
      </div>
      <div class="card my-4">
        <h3 class="card-title">Trama</h3>
        <div class="card-text">${movie.overview}</div>
      </div>

      <div class="btn-toolbar">
        <a href="index.html" class="btn btn-warning">Torna Indietro</a>   
        
        <button type="button" class="btn btn-primary mostraTrailer" onclick="hideShow()">Mostra/Nascondi trailer</button>  
        <button type="button" class="btn btn-primary " ">Scrivi una recensione </button>  
          
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

function hideShow() {
  var trailer = document.getElementById("trailers")
  trailer.style.display = trailer.style.display == "none" ? "flex" : "none";
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

