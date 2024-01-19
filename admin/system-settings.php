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
                            if($row["logoType"]!==null&&$row["logoData"]!==null){
                                $logo = 'data:'.$row["logoType"].';base64,'.base64_encode($row["logoData"]);
                            }else{
                                $logo = null;
                            }
                            if($row["aboutType"]!==null&&$row["aboutData"]!==null){
                                $aboutPhoto = 'data:'.$row["aboutType"].';base64,'.base64_encode($row["aboutData"]);
                            }else{
                                $aboutPhoto = null;
                            }
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
                                <input type="tel" class="form-control" name="contact" id="mobile" value="<?= $row['contact'] ?>">
                            </div>
                            <div class="mb-3 text-center">
                                <img src="<?= $logo ?? '../image/image-placeholder.png' ?>" alt="image" width="150" class="rounded img-thumbnail" id="image1">
                            </div>
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control"  accept="image/*" name="logo" id="imagein1">
                            </div>
                            <div class="mb-3 text-center">
                                <img src="<?= $aboutPhoto ?? '../image/image-placeholder.png' ?>" alt="image" width="150" class="rounded img-thumbnail" id="image2">
                            </div>
                            <div class="mb-3">
                                <label for="aboutImage" class="form-label">About image</label>
                                <input type="file" class="form-control"  accept="image/*" name="aboutImage" id="imagein2">
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


        if(!systemname || !email || !contact || !logo || !aboutimage || !aboutcontent) {
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