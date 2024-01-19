document.addEventListener('DOMContentLoaded', function () {

    const forumData = [];
    const commentData = [];
    const alumniData = [];

    let user = JSON.parse(sessionStorage.user || null);

    $('#postImg').on('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        $('#dpl').attr('src', URL.createObjectURL(file))
      }
    })

    if(user != null){
      const createdBy = document.getElementById('userS');
      const topicId = document.getElementById('topicId');
      const contentId = document.getElementById('contentId');

      $(document).ready(function(e) {
        $('#createPost').on('submit', function(e) {
          e.preventDefault();
          console.log('ready to create post.');

          
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
          jobc: alumni.jobC,
          forumc: alumni.forumC,
          commentc: alumni.commentC
        });
      });
    }

    function updateCommentData(data) {
      
      commentData.length = 0; 
    
        data.forEach(comment => {
          commentData.push({
            id: comment.id,
            forumId: comment.forumId,
            comments: comment.comments,
            studentId: comment.studentId,
            timestamp: comment.timestamp
          });
        });
    }
    
    function fetchData(){

      const alumniPromise = fetch('php/alumnis.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {
        updateAlumniData(data);
      })
      .catch(error => console.error('Error fetching alumni data:', error));

      const forumPromise = fetch('php/forums.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {

        updateForumData(data);
      })
      .catch(error => console.error('Error fetching forum data:', error));

      const commentPromise = fetch('php/comment.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {

        updateCommentData(data);
      })
      .catch(error => console.error('Error fetching comment data:', error));

    Promise.all([forumPromise, commentPromise, alumniPromise])
    .then(() => updateForumSource());

    Promise.all([alumniPromise])
    .then(() => topicCreateRestriction());
    }

    function updateForumSource(){
      let user = JSON.parse(sessionStorage.user || null);
      const userData = alumniData.find(alumni => alumni.id === user.id);
      const forumsData = document.querySelector('.forumData');
      forumsData.innerHTML = '';

      forumData.forEach( data => {
        const commentsForForum = commentData.filter(comment => comment.forumId === data.id);
        const forumHTMLData = `
        <tr>
          <td>
            <p class="ptag">Created by: ${data.created}</p>
            <h3><i class="fa fa-book"></i>${data.topic}</h3>
            <a class="ptag text-muted viewTopic" role="button" data-id="${data.id}"><i class="fa fa-eye"></i>View</a>
            <span class="ptag"> Posted Date: ${data.timestamp}</span> 
          </td>
          <td style="padding: 1.5rem;" class="text-muted text-center"><p>${commentsForForum.length}</p></td>
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
          $('#backForum').click(function(){
            $('#main').show();
            $('#post').html('');
          });

          if(userData.commentc!=='0'){
            const commentHtml = `
            <div class="mb-3">
              <form id="createComment" class="row g-2">
                <div class="col-11">
                  <input type="hidden" name="topic" value="${topicId}">
                  <input type="hidden" name="id" value="${userData.id}">
                  <textarea class="form-control" name="comment" rows="3"></textarea>
                </div>
                <div class="col-sm">
                  <input type="submit" class="btn btn-primary" value="Submit">
                </div>
              </form>
            </div>
            `;
            $('#post').append(commentHtml);
            $(document).ready(function(e) {
              $('#createComment').on('submit', function(e) {
                e.preventDefault();
                if($('textarea[name="comment"]').val().trim() === ''){
                  alert('Error: Comment cannot be empty.');
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
                      if(data.error){
                        console.log(data.error);
                      }else{
                        console.log(data);
                      }
                    }
                  });
                }
              });
            });
          }else{
            const commentHtml = `
            <div class="text-center text-muted"><i class="fa-solid fa-triangle-exclamation text-danger"></i><h5>Comment Restricted.</h5></div>
            `;
            $('#post').append(commentHtml);
          }
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
        const commentAlumni = alumniData.find(alumni => alumni.id === cData.studentId);
        const viewCommentHTMLData = `
        <div class="row">
          <div class="col-1">
            <figure class="figure">
              <img src="${commentAlumni.photo || 'https://www.freeiconspng.com/uploads/--tie-user-users-work-worker-working-icon--icon-search-engine-6.png'}" class="figure-img img-fluid rounded">
              <figcaption class="figure-caption text-center">${commentAlumni.firstname || ''}</figcaption>
            </figure>
          </div>
          <div class="col-11">
            <div class="card" style="padding: .5rem;">
              <p>${cData.comments}</p>
            </div>
            <p class="text-end ptag">Posted Date: ${cData.timestamp}</p>
          </div>
        </div>
        `;
        $('#commentsContent').append(viewCommentHTMLData);
      })
    }

    function topicCreateRestriction(){
      let user = JSON.parse(sessionStorage.user || null);
      
      if(user != null){
        const userData = alumniData.find(alumni => alumni.id === user.id);
        const createTopic = document.querySelector('#createTopic');
        createTopic.innerHTML = '';
      
        if (userData) {
          if(userData.forumc!=='0'){
            const createTopicHTMLData = `
                <form id="createPost" class="card" enctype="multipart/form-data" style="padding: 1rem; margin: 1rem 0rem;">
                  <input type="hidden" name="id" value="${userData.id}">
                  <div class="row g-3">
                    <div class="col-8">
                      <div class="mb-3">
                        <input type="text" name="topic" id="topicId" class="form-control" placeholder="Topic Title">
                      </div>
                      <div class="mb-3">
                        <textarea class="form-control" rows="5" name="content" id="contentId" placeholder="Topic Content"></textarea>
                      </div>
                    </div>
                    <div class="col-3">
                      <img src="image/image-placeholder.png" class="rounded mx-auto d-block" style="width: 10rem;" id="dpl">
                      <input type="file" class="form-control" name="file1" accept="image/*" id="postImg">
                    </div>
                    <div class="col-sm">
                      <input type="submit" class="btn btn-primary" value="Create">
                    </div>
                  </div>
                </form>
            `;
            createTopic.insertAdjacentHTML('beforeend', createTopicHTMLData);
          }else{
            const createTopicHTMLData = `
            <div class="text-center text-muted"><i class="fa-solid fa-triangle-exclamation text-danger"></i><h5>Create Topic Restricted.</h5></div>
            `;
            createTopic.insertAdjacentHTML('beforeend', createTopicHTMLData);
          }
        } else {
          console.log('User not found in alumniData');
        }
      }
      
    }
    setInterval(() => {
      fetchData();
    }, 500);
  }

})