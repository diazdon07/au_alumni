                <!-- System Settings  -->
                <div class="card" id="settingForm">
                    <div class="card-header">
                        <i class="fa-solid fa-gear"></i> <span class="ms-1 d-sm-inline">System Settings</span>
                    </div>
                    <div class="card-body">
                        <form id="systemForm" enctype="multipart/form-data">
                            <input type="hidden" name="id">
                            <div class="mb-3">
                                <label for="systemName" class="form-label">System Name</label>
                                <input type="text" class="form-control" name="systemName">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="tel" class="form-control" name="contact" id="mobile">
                            </div>
                            <div class="mb-3 text-center">
                                <img src="https://www.freeiconspng.com/uploads/no-image-icon-6.png" alt="image" width="150" class="rounded img-thumbnail" id="image1">
                            </div>
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control"  accept="image/*" name="logo" id="imagein1">
                            </div>
                            <div class="mb-3 text-center">
                                <img src="https://www.freeiconspng.com/uploads/no-image-icon-6.png" alt="image" width="150" class="rounded img-thumbnail" id="image2">
                            </div>
                            <div class="mb-3">
                                <label for="aboutImage" class="form-label">About image</label>
                                <input type="file" class="form-control"  accept="image/*" name="aboutImage" id="imagein2">
                            </div>
                            <div class="mb-3">
                                <label for="aboutContent" class="form-label">About Content</label>
                                <textarea class="form-control" name="aboutContent" rows="3"></textarea>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <input type="submit" class="btn btn-primary" name="submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
<script>
document.addEventListener('DOMContentLoaded', function () {

  const systemData2 = [];
  
  function updatesystemData(data) {
      
    systemData2.length = 0; // Clear the existing systemData array
    // Push each fetched event to the systemData array
      data.forEach(system => {
        systemData2.push({
          id: system.id,
          systemname: system.systemname,
          email: system.email,
          contact: system.contact,
          logo: system.logo,
          aboutimage: system.aboutimage,
          aboutcontent: system.aboutcontent
        });
      });
  }

  function fetchSystemData() {
    const systemPromise = fetch('../php/system.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {

        updatesystemData(data);
      })
    .catch(error => console.error('Error fetching gallery data:', error));
    systemPromise.then(() => updateSource());
  }

  function updateSource(){
    systemData2.forEach(data =>{
      $('input[name="systemName"]').val(data.systemname);
      $('input[name="id"]').val(data.id);
      $('input[name="email"]').val(data.email);
      $('input[name="contact"]').val(data.contact);
      $('#image1').attr('src',data.logo);
      $('#image2').attr('src',data.aboutimage);
      $('textarea[name="aboutContent"]').html(data.aboutcontent);
    })
    
  }

  fetchSystemData();

$('#mobile').keydown(function(event) {
    if(!isNaN(event.key) || event.key === 'Backspace') {
        if($(this).val().length >= 10 && event.key !== 'Backspace'){
            event.preventDefault();
        }
    }else{
        event.preventDefault();       
    }
})
    
$(document).ready(function(e) {
    $('#systemForm').on('submit',function(e) {
      e.preventDefault();

        const systemname = $('input[name="systemName"]').val();
        const email = $('input[name="email"]').val();
        const contact = $('input[name="contact"]').val();
        const logo = $('input[name="logo"]').val();
        const aboutimage = $('input[name="aboutImage"]').val();
        const aboutcontent = $('textarea[name="aboutContent"]').val();


        if(!systemname || !email || !contact || !aboutcontent) {
            console.log('Please input all details.');
        } else {
            $.ajax({
                type: 'POST',
                url: 'function/action.php?action=System',
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
                    showMessage('error',data.error);
                  }else{
                    showMessage('success',data);
                    setInterval(() => {
                      location.reload();
                    }, 5000);
                  }
                }
            });
        }
    });
});

$('#imagein1').on('change', function(event) {
  const file = event.target.files[0];
  if (file) {
    $('#image1').attr('src', URL.createObjectURL(file))
  }
})
$('#imagein2').on('change', function(event) {
  const file = event.target.files[0];
  if (file) {
    $('#image2').attr('src', URL.createObjectURL(file))
  }
})
})
</script>