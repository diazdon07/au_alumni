document.addEventListener('DOMContentLoaded', function () {

    const createdBy = document.getElementById('userS');
    const topicId = document.getElementById('topicId');
    const contentId = document.getElementById('contentId');

    const forumData = [];

    let user = JSON.parse(sessionStorage.user || null);
  
    $('#postImg').on('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        $('#dpl').attr('src', URL.createObjectURL(file))
      }
    })
  
    $(document).ready(function(e) {
      $('#createPost').on('submit', function(e) {
        e.preventDefault();
        console.log('ready to create post.');

        if(user != null){
          createdBy.value = user.firstname;
           if(!topicId.value.length || !contentId.value.length){
            console.log('No Details Input');
          }else{
            $.ajax({
              type: 'POST',
              url: 'php/action.php?action=Forum',
              data: new FormData(this),
              datatype: 'json',
              contentType: false,
              cache: false,
              processData: false,
              error: function(err) {
                console.log('error: ', err);
              },
              success: function(data) {
                console.log(data);
                location.reload();
              }
            });
          }
        }else{
          location.replace('login_student.php');
        }

      })
    })

    function updateForumData(data) {
      
      forumData.length = 0; 
    
        data.forEach(forum => {
          forumData.push({
            id: forum.id,
            topic: forum.topic,
            img: forum.img,
            content: forum.content,
            created: forum.created,
            timestamp: forum.timestamp
          });
        });
        updateForumSource(); 
      }
    
    function fetchData(){
      fetch('php/forums.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {

        updateForumData(data);
      })
      .catch(error => console.error('Error fetching forum data:', error));
    }

    function updateForumSource(){
      const forumsData = document.querySelector('.forumData');
      forumsData.innerHTML = '';

      forumData.forEach( data => {
        const forumHTMLData = `
        <tr>
          <td>
            <p class="ptag">Created by: ${data.created}</p>
            <h3><i class="fa fa-book"></i>${data.topic}</h3>
            <a class="ptag text-muted" role="button" id="viewTopic"><i class="fa fa-eye"></i>View</a>
            <span class="ptag"> Posted Date: ${data.timestamp}</span> 
          </td>
          <td style="padding: 1.5rem;" class="text-muted text-center"><p>5</p></td>
        </tr>
        `;
        forumsData.insertAdjacentHTML('beforeend', forumHTMLData);
      })
    }
  
  fetchData();
})