document.addEventListener('DOMContentLoaded', function () {
    const ddlYears = document.getElementById("year");
    const currentYear = (new Date()).getFullYear();
    
    const alumniData = [];
    const courseData = [];
  
    for (let i = 2000; i <= currentYear; i++) {
      const optionYears = document.createElement("option");
      optionYears.innerHTML = i;
      optionYears.value = i;
      ddlYears.appendChild(optionYears);
    }
  
    function coursesDdl(data) {
      const ddlCourses = document.getElementById("course");
  
      data.forEach(courses => {
        const optionCourses = document.createElement("option");
        optionCourses.textContent = courses.course;
        optionCourses.value = courses.id;
        ddlCourses.appendChild(optionCourses);
      });
    }
  
    function updateAlumniData(data) {
    
      alumniData.length = 0; // Clear the existing eventData array
      // Push each fetched event to the alumniData array
      data.forEach(alumni => {
        alumniData.push({
          id: alumni.id,
          student_number: alumni.student_number,
          firstname: alumni.firstname,
          middlename: alumni.middlename,
          lastname: alumni.lastname,
          gender: alumni.gender,
          address: alumni.address,
          city: alumni.city,
          course: alumni.course,
          batch: alumni.batch,
          photo: alumni.photo,
          status: alumni.status,
          position: alumni.position,
          company: alumni.company
        });
      });
    }
  
    function updateCoursesData(data) {
    
      courseData.length = 0; // Clear the existing courseData array
      // Push each fetched event to the courseData array
      data.forEach(course => {
        courseData.push({
          id: course.id,
          course: course.course
        });
      });
    }
  
    // Function to display filtered results
    function displayFilteredResults(data) {
      const alumniContent = document.querySelector('.alumnicontent');
      alumniContent.innerHTML = ''; // Clear previous content
  
      data.forEach(alumni => {
        const alumniCourse = courseData.find(course => course.id === alumni.course);
        if(alumni.photo === undefined  || alumni.photo === null){
          var image = 'https://www.freeiconspng.com/uploads/no-image-icon-6.png';
        }else{
          var image = alumni.photo;
        }
        
        const alumniCardHTML = `
        <div class="col-auto alumniBtn" role="button" data-id="${alumni.id}">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <img class="card-img-top" src="${image}">
              <h5 class="card-title">${alumni.firstname} ${alumni.lastname}</h5>
              <p class="card-text">Student Number: ${alumni.student_number}</p>
              <p class="card-text">Gender: ${alumni.gender === '0' ? 'Male' : 'Female'}</p>
              <p class="card-text">Program: ${alumniCourse ? alumniCourse.course : 'Unknown'}</p>
              <p class="card-text">Batch: ${alumni.batch}</p>
              <p class="card-text">Employement Status: ${alumni.status === '0' ? 'Unemployed' : 'Employed'}</p>
            </div>
          </div>
        </div>
        `;
  
        alumniContent.insertAdjacentHTML('beforeend', alumniCardHTML);
      });
      document.querySelectorAll('.alumniBtn').forEach(element => {
        element.addEventListener('click', function() {
          console.log(`Click Alumni card ID no.: ${this.getAttribute('data-id')}`);
          $('#alumniList').hide();
          $('#alumniView').show();

          const backHtml =`
          <div class="mb-3">
            <a role="button" class="ptag text-muted" id="backAlumni"><i class="fa fa-chevron-left"></i> Back</a>
          </div>
          `;
          
          $('#alumniView').append(backHtml);

          $('#backAlumni').click(function(){
            $('#alumniList').show();
            $('#alumniView').html('');
          });

          const dataDetails = alumniData.find(alumni => alumni.id === this.getAttribute('data-id'));
          const course = courseData.find(course => course.id === dataDetails.course);
          
          const alumniHTML = `
            <div class="row">
              <div class="col-4">
                <figure class="figure">
                  <img src="${dataDetails.photo || 'https://www.freeiconspng.com/uploads/no-image-icon-6.png'}" class="figure-img img-fluid rounded" width="500" height="500">
                </figure>
              </div>
              <div class="col">
                <div class="row">
                  <h3>${dataDetails.lastname}, ${dataDetails.firstname}</h3>
                </div>
                <hr>
                <div class="row">
                  <p><b>Student No.: ${dataDetails.student_number}</b></p>
                </div>
                <div class="row">
                  <h6>Program: ${course.course}</h6>
                </div>
                <div class="row">
                  <h6>Batch: ${dataDetails.batch}</h6>
                </div>
                <div class="row">
                  <h6>Gender: ${dataDetails.gender === '0' ? 'Male' : 'Female'}</h6>
                </div>
                <div class="row">
                  <h6>Employment Status: ${dataDetails.status === '0' ? 'Unemployed' : 'Employed'}</h6>
                </div>
                <div class="row">
                  ${dataDetails.position!==null? '<h6>Position: '+dataDetails.position+'</h6>':''}
                </div>
                <div class="row">
                  ${dataDetails.company!==null ? '<h6>Company: '+ dataDetails.company+'</h6>': ''}
                </div>
              </div>
            </div>
          `;
          $('#alumniView').append(alumniHTML);
        })
      })
    }

    function fetchData() {

      const courseFetch = fetch('php/courses.php')
        .then(response => response.json()) // Assuming the PHP returns JSON data
        .then(data => {
          // Use the received data as the CoursesData
          coursesDdl(data);
          updateCoursesData(data);
        })
        .catch(error => console.error('Error fetching courses data:', error));

      const alumniFetch = fetch('php/alumnis.php')
        .then(response => response.json()) // Assuming the PHP returns JSON data
        .then(data => {
          // Use the received data as the alumniData
          displayFilteredResults(data);
          updateAlumniData(data);
        })
        .catch(error => console.error('Error fetching alumni data:', error));

    }
  
    // Add event listener to the Search button to handle filtering
    $('#searchBtn').click(function() {
      const searchValue = document.getElementById('search').value.toLowerCase();
      const selectedGender = document.getElementById('gender').value;
      const selectedCourse = document.getElementById('course').value;
      const selectedBatch = document.getElementById('year').value;
      const selectedStatus = document.getElementById('status').value;
  
      // Filter the alumni data based on the selected criteria
      const filteredAlumni = alumniData.filter(alumni => {
        const alumniFirstNameLower = alumni.firstname.toLowerCase();
        const alumniLastNameLower = alumni.lastname.toLowerCase();
        const alumniFullNameLower = `${alumniLastNameLower} ${alumniFirstNameLower}`;
        const alumniStudentNumberLower = alumni.student_number.toLowerCase();
        return (
          (searchValue === '' ||
            alumniFirstNameLower.includes(searchValue) ||
            alumniLastNameLower.includes(searchValue) ||
            alumniFullNameLower.includes(searchValue) ||
            alumniStudentNumberLower.includes(searchValue)) &&
          (selectedGender === '-Select Gender-' || alumni.gender === selectedGender) &&
          (selectedCourse === '-Select Program-' || alumni.course === selectedCourse) &&
          (selectedBatch === '-Select Batch-' || alumni.batch == selectedBatch) &&
          (selectedStatus === '-Select Employment Status-' || alumni.status === selectedStatus)
        );
      });
  
      // Display the filtered results
      displayFilteredResults(filteredAlumni);
    });
  
    // Call the fetch function initially to load all alumni data
    fetchData();
   
});
