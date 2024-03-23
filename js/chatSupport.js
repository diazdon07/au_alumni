document.addEventListener('DOMContentLoaded', function () {
  $('#chat_box').click(function(){
    const chatForm = document.querySelector('#chat');
    chatForm.innerHTML = '';

    console.log('Message click.');

    $('#chat_box').hide();
    
    const chatFormHTMLData = `
    <div class="card chat_form">
      <div class="card-header">
        Admin Chat
        <button type="button" class="btn-close" style="float: right;"></button>
      </div>
      <div class="card-body scrollable" tabindex="0">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-1">
              <figure class="figure">
                <img src="https://www.freeiconspng.com/uploads/--tie-user-users-work-worker-working-icon--icon-search-engine-6.png" class="figure-img img-fluid rounded" alt="Admin">
                <figcaption class="figure-caption text-center">Admin</figcaption>
              </figure>
            </div>
            <div class="col-11">
              <div class="card" style="left: 1rem;padding: .5rem;">
                <p>Hi! There..</p>
              </div>
              <p class="text-end ptag">Sent: time</p>
            </div>
            <div class="col-12">
              <div class="card" style="padding: .5rem;">
                <p>Hi! There..</p>
              </div>
              <p class="text-start ptag">Sent: time</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="row align-items-center">
          <div class="col-9">
            <input type="text" name="" class="form-control" placeholder="Message...">
          </div>
          <div class="col-3">
            <a href="#" class="btn btn-primary"><i class="fa-regular fa-paper-plane"></i> Sent</a>
          </div>
        </div>
      </div>
    </div>
    `;
      chatForm.insertAdjacentHTML('beforeend', chatFormHTMLData);

    $('.btn-close').click(function(){
      $('#chat_box').show();
      $('#chat').html('');
    });
  });
});