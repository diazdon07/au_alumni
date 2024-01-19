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
                <div class="card">
                <img src="${data.photo || 'image/image-placeholder.png'}" class="img-fluid" alt="${data.title}">
                </div>
            </div>
            `;
            cardData.insertAdjacentHTML('beforeend', galleryHTMLData);
          });
    }

    setInterval(() => {
      fetchData();
    }, 500);
})