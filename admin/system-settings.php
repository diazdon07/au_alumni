                <!-- System Settings  -->
                <div class="card" id="settingForm">
                    <div class="card-header">
                        <i class="fa-solid fa-gear"></i> <span class="ms-1 d-sm-inline">System Settings</span>
                    </div>
                    <div class="card-body">
                        <form id="systemForm" enctype="multipart/form-data">
                          <?php 
                          $result = mysqli_query($conn,'SELECT * FROM `system`');
                          while($row = mysqli_fetch_assoc($result)):
                          ?>
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <div class="mb-3">
                                <label for="systemName" class="form-label">System Name</label>
                                <input type="text" class="form-control" name="systemName" value="<?= $row['systemname'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= $row['email'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="tel" class="form-control" name="contact" value="<?= $row['contact'] ?>">
                            </div>
                            <div class="mb-3 text-center">
                                <img src="../image/<?= $row['logo'] ?? 'image-placeholder.png' ?>" alt="image" width="150" class="rounded img-thumbnail" id="image1">
                            </div>
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control"  accept="image/*" name="file1" id="imagein1">
                            </div>
                            <div class="mb-3 text-center">
                                <img src="../image/<?= $row['aboutimage'] ?? 'image-placeholder.png' ?>" alt="image" width="150" class="rounded img-thumbnail" id="image2">
                            </div>
                            <div class="mb-3">
                                <label for="aboutImage" class="form-label">About image</label>
                                <input type="file" class="form-control"  accept="image/*" name="file2" id="imagein2" value="<?= $row['aboutimage'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="aboutContent" class="form-label">About Content</label>
                                <textarea class="form-control" name="aboutContent" rows="3"><?= $row['aboutcontent'] ?></textarea>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <input type="submit" class="btn btn-primary" name="submit" value="Save">
                            </div>
                          <?php 
                          endwhile;
                          ?>
                        </form>
                    </div>
                </div>
<script>
const systemname = document.getElementsByName('systemName').value
const email = document.getElementsByName('email').value
const contact = document.getElementsByName('contact').value
const logo = document.getElementsByName('logo')
const aboutimage = document.getElementsByName('aboutImage')
const aboutcontent = document.getElementsByName('aboutContent').value
    
$(document).ready(function(e) {
    $('#systemForm').on('submit',function(e) {
      e.preventDefault();

        if(!systemname || !email || !contact || !logo.value || !aboutimage.value || !aboutcontent) {
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
                    console.log(data);
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
</script>