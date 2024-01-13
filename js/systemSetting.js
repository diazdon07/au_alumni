document.addEventListener('DOMContentLoaded', function () {

    const imgs = document.getElementsByClassName('imgLogo');
    const aboutImgs = document.getElementsByClassName('imgAbout');
    const name = document.getElementsByClassName('systemName');
    const email = document.getElementsByClassName('systemEmail');
    const contact = document.getElementsByClassName('systemContact');
    const aboutcontent = document.getElementsByClassName('systemContent');

    const systemData = [];
  
    function updatesystemData(data) {
      
    systemData.length = 0; // Clear the existing systemData array
    // Push each fetched event to the systemData array
      data.forEach(system => {
        systemData.push({
          systemname: system.systemname,
          email: system.email,
          contact: system.contact,
          logo: system.logo,
          aboutimage: system.aboutimage,
          aboutcontent: system.aboutcontent
        });
      });
  
      updateSource();
  
    }
  
    function fetchsystemData() {
      fetch('php/system.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {
      // Use the received data as the settingData
        updatesystemData(data);
      })
      .catch(error => console.error('Error fetching courses data:', error));
    }
  
    function updateSource() {

      const defaultImageSrc = 'https://www.freeiconspng.com/uploads/no-image-icon-4.png';
      const defaultText = 'No Text Data.';

      Array.from(imgs).forEach((img) => {
        if (systemData.length === 0 || systemData[0].logo === null) {
          img.src = defaultImageSrc;
        } else {
          img.src = `image/${systemData[0].logo}`;
        }
      });

      Array.from(aboutImgs).forEach((aboutImg) => {
        if (systemData.length === 0 || systemData[0].aboutimage === null) {
          aboutImg.src = defaultImageSrc;
        } else {
          aboutImg.src = `image/${systemData[0].aboutimage}`;
        }
      });

      Array.from(name).forEach((names) => {
        if (systemData.length === 0 || systemData[0].systemname === null) {
          names.textContent = defaultText;
        } else {
          names.textContent = systemData[0].systemname;
        }
      });

      Array.from(email).forEach((emails) => {
        if (systemData.length === 0 || systemData[0].email === null) {
          emails.textContent = defaultText;
        } else {
          emails.textContent = systemData[0].email;
        }
      });

      Array.from(contact).forEach((contacts) => {
        if (systemData.length === 0 || systemData[0].contact === null) {
          contacts.textContent = defaultText;
        } else {
          contacts.textContent = systemData[0].contact;
        }
      });

      Array.from(aboutcontent).forEach((aboutcontents) => {
        if (systemData.length === 0 || systemData[0].aboutcontent === null) {
          aboutcontents.textContent = defaultText;
        } else {
          aboutcontents.textContent = systemData[0].aboutcontent;
        }
      });
    }
  
    fetchsystemData();
  
});