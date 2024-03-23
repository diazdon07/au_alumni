document.addEventListener('DOMContentLoaded', function () {

  const ctx = document.getElementById('Chart');

  let DataSets = [];

  function chartData(data){
    DataSets.length = 0;
  
    data.forEach(set => {
      const yearData = { year: set.year };
      // Loop through each property in the set
      for (const [key, value] of Object.entries(set)) {
        // Skip the year property
        if (key !== 'year') {
          // Add program and count to the yearData object
          yearData[key] = value;
        }
      }
      // Push the constructed object to DataSets
      DataSets.push(yearData);
    });
  }

  function fetchData(){
    const chartPromise = fetch('../php/chartData.php')
    .then(response => response.json())
    .then(data => {
      chartData(data)
    })
    .catch(error => console.error('Error fetching data:', error));

    chartPromise.then(() => updateSource());
  }

  function updateSource(){

  const data = {
    labels: DataSets.map(row => row.year),
      datasets: [{
        label: 'BS IT',
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
        borderColor: 'rgb(255, 99, 132)',
        data: DataSets.map(row => row.BSIT),
        borderWidth: 1
      },{
        label: 'BS CS',
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgb(54, 162, 235)',
        data: DataSets.map(row => row.BSCS),
        borderWidth: 1
      },{
        label: 'BS IS',
        backgroundColor: 'rgba(75, 192, 192, 0.5)',
        borderColor: 'rgb(75, 192, 192)',
        data: DataSets.map(row => row.BSIS),
        borderWidth: 1
      }]
  };
    
  new Chart(ctx, {
    type: 'bar',
    data: data,
      options: {
        plugins: {
          title: {
            text: 'Alumni Batch Chart',
            display: true
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }
    
  fetchData()
});