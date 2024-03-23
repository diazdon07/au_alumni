document.addEventListener('DOMContentLoaded', function () {

    const jobsData = [];
  
    function updateJobData(data) {
        
      jobsData.length = 0; 
      
        data.forEach(job => {
          jobsData.push({
            id: job.id,
            title: job.job_title,
            company: job.company,
            shortDesc: job.shortdesc,
            description: job.description,
            link: job.link,
            parttime: job.parttime,
            fulltime: job.fulltime,
            contractual: job.contractual,
            status: job.status
          });
        });
        updateJobSource(); 
    }
  
    function fetchData(){
      const jobPromise = fetch('php/jobs.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {
  
         updateJobData(data);
      })
      .catch(error => console.error('Error fetching job data:', error));

  
      jobPromise.then(() => {
        updateJobSource();
      })
      }
     
    function updateJobSource(){
      const jobOfferData = document.querySelector('.jobOfferData');
      jobOfferData.innerHTML = '';
  
      jobsData.forEach( data => {
        if(data.status!=='0'){
          let titleHTML = `<h6>${data.title}`;
            if (data.parttime === '1' && data.fulltime === '1' && data.contractual === '1'){
              titleHTML += ' <span class="text-note All">All</span>';
            }else{
              if (data.parttime === '1') {
                titleHTML += ' <span class="text-note partTime">Part Time</span> ';
              }
  
              if (data.fulltime === '1') {
                titleHTML += ' <span class="text-note fullTime">Full Time</span> ';
              }
  
              if (data.contractual === '1') {
                titleHTML += ' <span class="text-note contractual">Contractual</span>';
              }
            }
  
            titleHTML += '</h6>';
  
          const jobHTMLData = `
          <tr>
            <td class="card card-list" data-title="${data.title}" data-company="${data.company}" data-short="${data.shortDesc}" data-description="${data.description}" 
            data-link="${data.link}" data-parttime="${data.parttime}" data-fulltime="${data.fulltime}" data-con="${data.contractual}"> 
              ${titleHTML}
              <span class="text-muted">${data.company}</span>
              <p>${data.shortDesc}</p>
            </td>
          </tr>
          `;
          jobOfferData.insertAdjacentHTML('beforeend', jobHTMLData);
        }else{
          const jobHTMLData = '';
          jobOfferData.insertAdjacentHTML('beforeend', jobHTMLData);
        }
          
          
        });
        $(document).ready( function () {
          $('#jobTable').DataTable();
        });
        document.querySelectorAll('.card-list').forEach(element => {
          element.addEventListener('click', function() {
  
          console.log('Job Offer click.');
  
          const title = this.getAttribute('data-title');
          const company = this.getAttribute('data-company');
          const shortDesc= this.getAttribute('data-short');
          const description= this.getAttribute('data-description');
          const link= this.getAttribute('data-link');
          const parttime= this.getAttribute('data-parttime');
          const fulltime= this.getAttribute('data-fulltime');
          const con= this.getAttribute('data-con');
  
          $('#jobList').hide();
  
          let titleHTML = `<h2>${title}`;
            if (parttime === '1' && fulltime === '1' && con === '1'){
              titleHTML += ' <span class="text-note All">All</span>';
            }else{
              if (parttime === '1') {
                titleHTML += ' <span class="text-note partTime">Part Time</span> ';
              }
  
              if (fulltime === '1') {
                titleHTML += ' <span class="text-note fullTime">Full Time</span> ';
              }
  
              if (con === '1') {
                titleHTML += ' <span class="text-note contractual">Contractual</span>';
              }
            }
  
            titleHTML += '</h2>';
  
            const backHtml =`
            <div class="mb-3">
              <a href="#" class="ptag text-muted" id="backForum"><i class="fa fa-chevron-left"></i> Back</a>
            </div>
            `;
  
            const jobViewHTMLData = `
            <div class="mb-3">
                ${titleHTML}
                <h5>${company}</h5>
                <p class="text-muted">${shortDesc}</p>
                <hr>
                <h4><i class="fa fa-file-text"></i> Job Overview</h4>
                <p>${description}</p>
                <a href="${link}">Click Here</a>
            </div>
            `;
            $('#viewJob').append(backHtml);
            $('#viewJob').append(jobViewHTMLData);
  
            $('#backForum').click(function(){
              $('#jobList').show();
              $('#viewJob').html('');
            });
  
  
          })
        })
    } 
    fetchData();
  })