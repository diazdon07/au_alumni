<link rel="stylesheet" href="../css/reportdesign.css">
<!-- Report  -->
<div class="card">
  <div class="card-header">
    <i class="fa-brands fa-wpforms"></i> <span class="ms-1 d-sm-inline">Report</span>
  </div>
  <div class="container-fluid row row-cols-1 row-cols-md-2 g-4">
    <div class="card-body">
      <div class="card card-width bg-primary text-bg-dark bg-gradient">
        <div class="card-header text-end" id="courseCount">
            <h2>10</h2>
        </div>
        <div class="card-body">
          BS IT <i class="fa fa-users"></i>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="card card-width bg-info text-bg-dark bg-gradient">
        <div class="card-header text-end" id="courseCount">
            <h2>20</h2>                 
        </div>
        <div class="card-body">
          Non BS IT <i class="fa fa-users"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="alumni-report-tab" data-bs-toggle="tab" data-bs-target="#alumni-report" type="button" role="tab" aria-controls="alumni-report" aria-selected="true">Alumni Reports</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="event-report-tab" data-bs-toggle="tab" data-bs-target="#event-report" type="button" role="tab" aria-controls="event-report" aria-selected="false">Event Reports</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="job-report-tab" data-bs-toggle="tab" data-bs-target="#job-report" type="button" role="tab" aria-controls="job-report" aria-selected="false">Job Reports</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <!-- alumni reports -->
    <div class="tab-pane fade show active" id="alumni-report" role="tabpanel" aria-labelledby="alumni-report-tab">
      <div class="container-fluid print-content" style="margin: 0.2rem 0rem;">
        <form class="row g-1" id="alumniReport">
          <div class="col-11 header-report">
            <h6>Alumni Management System (Alumni Reports)</h6>
          </div>
          <div class="col-1 text-center">
            <a href="#" class="btn btn-primary" name="printAlumni" style="font-size: smaller;"><i class="fa-solid fa-print"></i> Print</a>
          </div>
          <table id="alumniTable">
            <thead>
                <th class="text-center" style="min-width: 1.2rem; max-width: 1.5rem;">No.</th>
                <th>Lastname</th>
                <th>Middlename</th>
                <th>Firstname</th>
                <th>Course</th>
                <th class="text-center" style="width: 70px;">Year Graduate</th>
                <th style="width: 80px;">Employment Status</th>
            </thead>
            <tbody class="alumniTbody">
                <tr>
                    <td class="text-center">1</td>
                    <td>Diaz</td>
                    <td>Dela Cruz</td>
                    <td>Don McLin</td>
                    <td>BS Information Technology</td>
                    <td class="text-center">2024</td>
                    <td>Unemployed</td>
                </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
    <!-- event reports -->
    <div class="tab-pane fade" id="event-report" role="tabpanel" aria-labelledby="event-report-tab">
      <div class="container-fluid" style="margin: 0.2rem 0rem;">
        <form class="row g-1" id="alumniReport">
          <div class="col-11 header-report">
            <h6>Alumni Management System (Event Reports)</h6>
          </div>
          <div class="col-1 text-center">
            <a href="#" class="btn btn-primary" name="printEvent" style="font-size: smaller;"><i class="fa-solid fa-print"></i> Print</a>
          </div>
          <table id="eventTable">
            <thead>
                <th class="text-center" style="min-width: 1.2rem; max-width: 1.5rem;">No.</th>
                <th>Lastname</th>
                <th>Middlename</th>
                <th>Firstname</th>
                <th>Course</th>
                <th class="text-center" style="width: 70px;">Year Graduate</th>
                <th style="width: 80px;">Employment Status</th>
            </thead>
            <tbody class="eventTbody">
                <tr>
                    <td class="text-center">1</td>
                    <td>Diaz</td>
                    <td>Dela Cruz</td>
                    <td>Don McLin</td>
                    <td>BS Information Technology</td>
                    <td class="text-center">2024</td>
                    <td>Unemployed</td>
                </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
    <!-- job reports -->
    <div class="tab-pane fade" id="job-report" role="tabpanel" aria-labelledby="job-report-tab">
      <div class="container-fluid" style="margin: 0.2rem 0rem;">
        <form class="row g-1" id="alumniReport">
          <div class="col-11 header-report">
            <h6>Alumni Management System - (Job Reports)</h6>
          </div>
          <div class="col-1 text-center">
            <a href="#" class="btn btn-primary" name="printJob" style="font-size: smaller;"><i class="fa-solid fa-print"></i> Print</a>
          </div>
          <table id="jobTable">
            <thead>
                <th class="text-center" style="min-width: 1.2rem; max-width: 1.5rem;">No.</th>
                <th>Lastname</th>
                <th>Middlename</th>
                <th>Firstname</th>
                <th>Course</th>
                <th class="text-center" style="width: 70px;">Year Graduate</th>
                <th style="width: 80px;">Employment Status</th>
            </thead>
            <tbody class="jobTbody">
                <tr>
                    <td class="text-center">1</td>
                    <td>Diaz</td>
                    <td>Dela Cruz</td>
                    <td>Don McLin</td>
                    <td>BS Information Technology</td>
                    <td class="text-center">2024</td>
                    <td>Unemployed</td>
                </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  $(document).ready(function () {
    // Initialize DataTable for each table
    var alumniTable = $('#alumniTable').DataTable();
    var eventTable = $('#eventTable').DataTable();
    var jobTable = $('#jobTable').DataTable();

    // Print function for Alumni tab
    $('a[name="printAlumni"]').click(function () {
      printTab('alumni-report', alumniTable);
    });

    // Print function for Event tab
    $('a[name="printEvent"]').click(function () {
      printTab('event-report', eventTable);
    });

    // Print function for Job tab
    $('a[name="printJob"]').click(function () {
      printTab('job-report', jobTable);
    });

    // Function to print the content of a specific tab
    function printTab(tabId, dataTable) {
      // Disable search before printing
      dataTable.search('').draw();
      
      var printContent = $('#' + tabId).clone();

      // Hide unnecessary elements in the print view
      printContent.find('.nav-tabs').remove();
      printContent.find('.tab-content').css('padding-top', '0');

      // Create a new window and print the content
      var printWindow = window.open('', '_blank');
      printWindow.document.write('<html><head><title>Print</title>');
      printWindow.document.write('<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">');
      printWindow.document.write('</head><body>');
      printWindow.document.write(printContent.html());
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();

      // Enable search back after printing
      dataTable.search('').draw();
    }
  });
});
</script>