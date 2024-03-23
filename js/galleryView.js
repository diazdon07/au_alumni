document.addEventListener('DOMContentLoaded', function () {
    const galleryData = [];

    function updateGalleryData(data) {
      
        galleryData.length = 0; 
      
          data.forEach(gallery => {
            galleryData.push({
              id: gallery.id,
              photo: gallery.photo,
              description: gallery.description,
              title: gallery.title
            });
          });
          updategallerySource(); 
    }
    
    function fetchData(){
        fetch('php/galleries.php')
        .then(response => response.json()) // Assuming the PHP returns JSON data
        .then(data => {
            updateGalleryData(data);
        })
        .catch(error => console.error('Error fetching gallery data:', error));
    }

    function updategallerySource(){
        const cardData = document.querySelector('.card-row');
        cardData.innerHTML = '';

        galleryData.forEach( data => {
            const galleryHTMLData = `
            <div class="col-4">
                <figure class="figure galleryBtn" data-id="${data.id}" role="button">
                  <img src="${data.photo || 'https://www.freeiconspng.com/uploads/no-image-icon-6.png'}" width="600" height="600" class="figure-img img-fluid rounded" alt="${data.title}">
                </figure>
            </div>
            `;
            cardData.insertAdjacentHTML('beforeend', galleryHTMLData);
          });
          document.querySelectorAll('.galleryBtn').forEach(element => {
            element.addEventListener('click', function() {
              console.log(`Click Gallery card ID no.: ${this.getAttribute('data-id')}`);
              
              $('#galleryList').hide();
              $('#galleryView').show();

              const backHtml =`
              <div class="mb-3">
                <a role="button" class="ptag text-muted" id="backGallery"><i class="fa fa-chevron-left"></i> Back</a>
              </div>
              `;
              
              $('#galleryView').append(backHtml);

              $('#backGallery').click(function(){
                $('#galleryList').show();
                $('#galleryView').html('');
              });

              const dataDetails = galleryData.find(gallery => gallery.id === this.getAttribute('data-id'));

              const galleryHTML = `
              <div class="row">
                <div class="col-4">
                  <figure class="figure">
                    <img src="${dataDetails.photo || 'https://www.freeiconspng.com/uploads/no-image-icon-6.png'}" class="figure-img img-fluid rounded" width="500" height="500">
                  </figure>
                </div>
                <div class="col">
                  <div class="row">
                    <h3>${dataDetails.title}</h3>
                  </div>
                  <hr>
                  <div class="row">
                    <p>${dataDetails.description}</p>
                  </div>
                </div>
              </div>
              `;
              $('#galleryView').append(galleryHTML);
            })
          })
    }

    fetchData();
})