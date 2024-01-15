document.addEventListener('DOMContentLoaded', function () {

    const createdBy = document.getElementById('userS');
    const topicId = document.getElementById('topicId');
    const contentId = document.getElementById('contentId');

    const forumData = [];
    const commentData = [];

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

    function updateCommentData(data) {
      
      commentData.length = 0; 
    
        data.forEach(comment => {
          commentData.push({
            id: comment.id,
            forumId: comment.forumId,
            comments: comment.comments,
            userId: comment.userId,
            timestamp: comment.timestamp
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

      fetch('php/comment.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {

        updateCommentData(data);
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
            <a class="ptag text-muted viewTopic" role="button" data-id="${data.id}"><i class="fa fa-eye"></i>View</a>
            <span class="ptag"> Posted Date: ${data.timestamp}</span> 
          </td>
          <td style="padding: 1.5rem;" class="text-muted text-center"><p>5</p></td>
        </tr>
        `;
        forumsData.insertAdjacentHTML('beforeend', forumHTMLData);
      });
      $(document).ready( function () {
        $('#forumTable').DataTable();
      });
      document.querySelectorAll('.viewTopic').forEach(element => {
        element.addEventListener('click', function() {
          
          // Access the data attributes
          const topicId = this.getAttribute('data-id');
          $('#main').hide();

          const backHtml =`
          <div class="mb-3">
            <a href="#" class="ptag text-muted" id="backForum"><i class="fa fa-chevron-left"></i> Back</a>
          </div>
          `;

          const commentHtml = `
          <div class="mb-3">
            <form id="createComment" class="row g-2">
              <div class="col-11">
                
                <textarea class="form-control" name="content" rows="3"></textarea>
              </div>
              <div class="col-sm">
                <input type="submit" class="btn btn-primary" value="Submit">
              </div>
            </form>
          </div>
          `;
          $('#post').append(backHtml);

          if(forumData.some(forum => forum.id === topicId)){
            viewForumSource(forumData);
          }else{
            console.log(`Error Forum Message: Forum ID no. ${topicId} Data Not Found`);
          }

          if(commentData.some(comment => comment.forumId === topicId)){
            viewCommentSource(commentData);
          }else{
            console.log(`Error Comment Message: Forum ID no. ${topicId} Data Not Found`);
          }

          $('#post').append(commentHtml);

          $('#backForum').click(function(){
            $('#main').show();
            $('#post').html('');
          });

          $(document).ready(function(e) {
            $('#createComment').on('submit', function(e) {
              e.preventDefault();

              if(user != null){
                createdBy.value = user.firstname;
                 if(!topicId.value.length || !contentId.value.length){
                  console.log('No Details Input');
                }else{
                  $.ajax({
                    type: 'POST',
                    url: 'php/action.php?action=Comments',
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
            });
          });
        });
      });
    }

    function viewForumSource(data) {
        
      data.forEach(fData => {
        const viewBodyHTMLData = `
        <div class="mb-3">
          <h2><i class="fa fa-book"></i>${fData.topic}</h2>
          <p>By ${fData.created} | Posted Date ${fData.timestamp}</p>
          <div class="card" style="padding: .5rem;">
            <img src="image/${fData.img || 'image-placeholder.png'}" class="img-thumbnail rounded mx-auto d-block" style="width: 30rem;">
            <p>${fData.content}</p>
          </div>
        </div>
        <div class="mb-3" id="commentsContent">
          
        </div>
        `;
        $('#post').append(viewBodyHTMLData);

      });
       
    }

    function viewCommentSource(data){

      data.forEach(cData => {
        const viewCommentHTMLData = `
        <div class="row">
          <div class="col-1">
            <figure class="figure">
              <img src="image/image-placeholder.png" class="figure-img img-fluid rounded">
              <figcaption class="figure-caption text-center">Don McLin</figcaption>
            </figure>
          </div>
          <div class="col-11">
            <div class="card" style="padding: .5rem;">
              <p>${cData.comments}</p>
            </div>
            <p class="text-end ptag">Replay Date: ${cData.timestamp}</p>
          </div>
        </div>
        `;
        $('#commentsContent').append(viewCommentHTMLData);
      })
    }
  
  fetchData();
})