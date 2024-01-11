document.addEventListener('DOMContentLoaded', function () {
    const ddlYears = document.getElementById("year");
    const currentYear = (new Date()).getFullYear();
    
    const alumniData = [];
    const courseData = [];
  
    for (var i = 1950; i <= currentYear; i++) {
      const optionYears = document.createElement("option");
      optionYears.innerHTML = i;
      optionYears.value = i;
      ddlYears.appendChild(optionYears);
    }
  
    function coursesDdl(data) {
      const ddlCourses = document.getElementById("course");
  
      data.forEach(courses => {
        const optionCourses = document.createElement("option");
        optionCourses.innerHTML = courses.course;
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
          photo: alumni.photo
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
        if(alumni.photo === '' || alumni.photo === null){
          var image = 'image/image-placeholder.png';
        }else{
          var image = 'upload/'+alumni.photo;
        }
        
        const alumniCardHTML = `
        <div class="col-auto">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <img class="card-img-top" src="${image}">
              <h5 class="card-title">${alumni.firstname} ${alumni.lastname}</h5>
              <p class="card-text">Student Number: ${alumni.student_number}</p>
              <p class="card-text">Gender: ${alumni.gender === '0' ? 'Male' : 'Female'}</p>
              <p class="card-text">Course: ${alumniCourse ? alumniCourse.course : 'Unknown'}</p>
              <p class="card-text">Batch: ${alumni.batch}</p>
              <!-- Include other alumni details as needed -->
            </div>
          </div>
        </div>
        `;
  
        alumniContent.insertAdjacentHTML('beforeend', alumniCardHTML);
        // Create HTML elements to display alumni details and append them to alumniContent
        // Example: Create cards or list items to display each alumni's information
        // alumniContent.appendChild(/* Create and append HTML elements */);
      });
    }
  
    function fetchCoursesData() {
      fetch('php/courses.php')
        .then(response => response.json()) // Assuming the PHP returns JSON data
        .then(data => {
          // Use the received data as the CoursesData
          coursesDdl(data);
          updateCoursesData(data);
        })
        .catch(error => console.error('Error fetching courses data:', error));
    }
  
    function fetchAlumniData() {
      fetch('php/alumnis.php')
        .then(response => response.json()) // Assuming the PHP returns JSON data
        .then(data => {
          // Use the received data as the alumniData
          updateAlumniData(data);
          displayFilteredResults(data);
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
        return (
          (searchValue === '' ||
            alumni.firstname.toLowerCase().includes(searchValue) ||
            alumni.lastname.toLowerCase().includes(searchValue) ||
            alumni.student_number.toLowerCase().includes(searchValue)) &&
          (selectedGender === '-Select Gender-' || alumni.gender === selectedGender) &&
          (selectedCourse === '-Select Course-' || alumni.course === selectedCourse) &&
          (selectedBatch === '-Select Batch-' || alumni.batch == selectedBatch) &&
          (selectedStatus === '-Select Employment Status-' || alumni.employment_status === selectedStatus)
        );
      });
  
      // Display the filtered results
      displayFilteredResults(filteredAlumni);
    })
  
    // Call the fetch function initially to load all alumni data
    fetchCoursesData()
    fetchAlumniData();
})