document.addEventListener('DOMContentLoaded', function () {
    const calendarDays = document.querySelector('.calendar-days');
    const calendarTitle = document.getElementById('calendarTitle');
    const weekDays = document.querySelector('.week-days');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
  
    let currentDate = new Date();
    let currentYear = currentDate.getFullYear();
    let currentMonth = currentDate.getMonth();
  
    prevBtn.addEventListener('click', () => {
      if (currentMonth === 0) {
          currentYear--;
          currentMonth = 11;
      } else {
          currentMonth--;
      }
      updateCalendar();
    });
  
    nextBtn.addEventListener('click', () => {
      if (currentMonth === 11) {
          currentYear++;
          currentMonth = 0;
      } else {
          currentMonth++;
      }
      updateCalendar();
    });
  
    const eventData = [];
  
    function updateCalendar() {
      calendarDays.innerHTML = '';
      calendarTitle.textContent = `${getMonthName(currentMonth)} ${currentYear}`;
  
      const today = new Date();
      const currentDay = today.getDate();
      const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
      const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
      const startingDay = firstDayOfMonth.getDay(); // 0 (Sunday) through 6 (Saturday)
      
      // Clear the week days section
      weekDays.innerHTML = '';
  
      // Get names of the days
      const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  
      // Display the names of the days
      for (let i = 0; i < dayNames.length; i++) {
        const dayNameElement = document.createElement('div');
        dayNameElement.textContent = dayNames[i];
        weekDays.appendChild(dayNameElement);
      }
  
      // Add empty placeholders for the days before the starting day of the month
      for (let i = 0; i < startingDay; i++) {
        const emptyDayElement = document.createElement('div');
        emptyDayElement.classList.add('empty-day');
        calendarDays.appendChild(emptyDayElement);
      }
  
      // Display the calendar dates
      for (let i = 1; i <= daysInMonth; i++) {
          const dayElement = document.createElement('div');
          dayElement.classList.add('calendar-day');
          dayElement.textContent = i;
  
          if (currentYear === today.getFullYear() && currentMonth === today.getMonth() && i === today.getDate()) {
              dayElement.classList.add('current-date');
          }
  
          // Check if the day has an event
          const eventForDay = eventData.filter(event => {
          const eventDate = new Date(event.date);
            return ( 
              eventDate.getFullYear() === currentYear &&
              eventDate.getMonth() === currentMonth &&
              eventDate.getDate() === i 
            );
          });
  
          if (eventForDay.length > 0) {
              dayElement.classList.add('event');
          }
  
          dayElement.addEventListener('click', () => {
              handleDateClick(currentYear, currentMonth, i, eventForDay);
          });
              calendarDays.appendChild(dayElement);
          }

          // Check if the current day has an event and display it
          const eventForCurrentDay = eventData.filter(event => {
          const eventDate = new Date(event.date);
            return (
              eventDate.getFullYear() === today.getFullYear() &&
              eventDate.getMonth() === today.getMonth() &&
              eventDate.getDate() === currentDay
            );
          });
          
          if (eventForCurrentDay.length > 0) {
            handleDateClick(today.getFullYear(), today.getMonth(), currentDay, eventForCurrentDay);
          }
  
    }
  
    function getMonthName(monthIndex) {
      const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
      ];
      return monthNames[monthIndex];
    }
  
    function handleDateClick(year, month, day, events) {
      const clickedDate = new Date(year, month, day);
      const eventDetailsContainer = document.getElementById('eventDetails');
      const eventDetailsContent = document.getElementById('areacontent');
      eventDetailsContainer.innerHTML = '';
      eventDetailsContent.innerHTML = '';
      console.log(`You clicked on: ${clickedDate.toDateString()}`);
  
      if (events.length > 0) {
  
        events.sort((a, b) => {
        // Sort events by time
          const timeA = a.time.split(':').map(part => parseInt(part));
          const timeB = b.time.split(':').map(part => parseInt(part));
          return timeA[0] - timeB[0] || timeA[1] - timeB[1];
        });

        // calendar bottom display
      events.forEach(event => {
        const eventRow = document.createElement('div');
        eventRow.classList.add('event-row');
        const eventTitle = document.createElement('span');
        eventTitle.textContent = event.title;
        const eventTime = document.createElement('p');
        eventTime.textContent = `(${event.timestart} - ${event.timeend})`;
        eventRow.appendChild(eventTitle);
        eventRow.appendChild(eventTime);
        eventDetailsContainer.appendChild(eventRow);
      });

        // content area
      events.forEach(event => {
        const eventRow = document.createElement('div');
        eventRow.classList.add('event-row');
        const eventTitle = document.createElement('h3');
        eventTitle.textContent = event.title;
        const eventTime = document.createElement('p');
        eventTime.textContent = `(${event.timestart} - ${event.timeend}) at ${event.location}`;
        const eventImage = document.createElement('img');
        eventImage.classList.add('img-fluid');
        if(event.image === null){
          eventImage.src = 'image/image-placeholder.png';
        }else{
          eventImage.src = event.image;
        }
        const eventDesc = document.createElement('p');
        eventDesc.classList.add('lh-sm');
        eventDesc.textContent = event.description;
        const eventUrl = document.createElement('a');
        eventUrl.classList.add('btn','btn-primary','me-md-2');
        eventUrl.href = event.url;
        eventUrl.textContent = 'URL'
        
        eventRow.appendChild(eventTitle);
        eventRow.appendChild(eventTime);
        eventRow.appendChild(eventImage);
        eventRow.appendChild(eventDesc);
        if(event.url !== null){
          eventRow.appendChild(eventUrl);
        }
        eventDetailsContent.appendChild(eventRow);
      });
  
        document.getElementById('eventTitle').textContent = 'Schedule';
        document.getElementById('eventDate').textContent = clickedDate.toDateString();
        document.getElementById('datecontent').textContent = 'Date: '+clickedDate.toDateString();
        // Add more event details if needed
        // Perform other actions for the selected date with an event
        // Example: Open a modal, call an API, etc.
      } else {
        // Handle cases when there's no event for the clicked date
        // For example, you might clear the event details display
      document.getElementById('eventTitle').textContent = 'No Event';
      document.getElementById('eventDate').textContent = clickedDate.toDateString();
      document.getElementById('datecontent').textContent = 'Date: '+clickedDate.toDateString();
        // Clear other event details if needed
      }
        // You can also perform additional actions based on the selected date
        // For instance, update the UI or trigger specific functionality.
    }

    function updateEventData(data) {
      // Assuming the fetched data has the same structure as your sample eventData
      eventData.length = 0; // Clear the existing eventData array
  
      // Push each fetched event to the eventData array
      data.forEach(event => {
        eventData.push({
          title: event.title,
          date: event.date,
          timestart: event.timestart,
          timeend: event.timeend,
          image: event.image,
          location: event.location,
          description: event.description,
          url: event.url
        });
      });
    }
  
    function fetchEventData() {
      fetch('php/events.php')
        .then(response => response.json()) // Assuming the PHP returns JSON data
        .then(data => {
          // Use the received data as the eventData
          updateEventData(data);
          updateCalendar();
        })
        .catch(error => console.error('Error fetching event data:', error));
    }

    
    setInterval(() => {
      fetchEventData();
      updateCalendar();
    }, 500);
  });