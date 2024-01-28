<div style="margin: 1rem;">
    <div class="card" style="padding: 1rem; min-height: 30rem;">
        <h6 class="text-muted">Create Job Offer</h6>
        <form id="jobForm">
            <div class="mb-3">
                <input type="text" class="form-control" name="job" placeholder="Job Title">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="company" placeholder="Company">
            </div>
            <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="partT" name="parttime">
                <label class="form-check-label" for="partT">
                Part Time
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="fullT" name="fulltime">
                <label class="form-check-label" for="fullT">
                Full Time
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="conT" name="contractual">
                <label class="form-check-label" for="conT">
                Contractual
                </label>
            </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="shortdesc" placeholder="Short Description">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="link" placeholder="Link">
            </div>
            <div class="mb-3">
                <textarea class="form-control" name="description" placeholder="Full Description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Submit"/>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
$(document).ready(function(e) {
  $('#jobForm').on('submit',function(e){
    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: 'php/action.php?action=createJob',
      data: new FormData(this),
      datatype: 'json',
      contentType: false,
      cache: false,
      processData: false,
      error: function(err) {
        console.log('error: ', err)
      },
      success: function(data) {
        if(data.error){
          console.log(data.error)
        }else{
          location.reload()
        }
      }
    })
  })
})
})
</script>