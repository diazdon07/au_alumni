function showMessage(alert,msg){
    const notifications = document.querySelector(".notifications");

    // Object containing details for different types of breads
    const breadDetails = {
        timer: 5000,
        success: {
            icon: 'fa-circle-check',
            text: `Success: ${msg}`,
        },
        error: {
            icon: 'fa-circle-xmark',
            text: `Error: ${msg}`,
        },
        warning: {
            icon: 'fa-triangle-exclamation',
            text: `Warning: ${msg}`,
        },
        info: {
            icon: 'fa-circle-info',
            text: `Info: ${msg}`,
        }
    }

    const createbread = (id) => {
        // Getting the icon and text for the bread based on the id passed
        const { icon, text } = breadDetails[id];
        const bread = document.createElement("li"); // Creating a new 'li' element for the bread
        bread.className = `bread ${id}`; // Setting the classes for the bread
        // Setting the inner HTML for the bread
        bread.innerHTML = `<div class="column">
                            <i class="fa-solid ${icon}"></i>
                            <span>${text}</span>
                        </div>
                        <i class="fa-solid fa-xmark" onclick="removebread(this.parentElement)"></i>`;
        notifications.appendChild(bread); // Append the bread to the notification ul
        // Setting a timeout to remove the bread after the specified duration
        bread.timeoutId = setTimeout(() => removebread(bread), breadDetails.timer);
    }
    createbread(alert)
}

const removebread = (bread) => {
    bread.classList.add("hide");
    if (bread.timeoutId) clearTimeout(bread.timeoutId); // Clearing the timeout for the bread
    setTimeout(() => bread.remove(), 500); // Removing the bread after 500ms
}