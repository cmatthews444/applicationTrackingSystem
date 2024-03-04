/*This file contains scripts to get announcements
* made in the last five days for the student homepage.
*
* Author: Sage Markwardt
* Date last touched: 2/28/2024
* File: get-announcements.js
* */window.addEventListener("load", function (event) {
    getAnnouncements();
})

async function getAnnouncements() {
    // first grab the date range +-5
    let today = new Date();
    let lastFiveDays = new Date(today);
    lastFiveDays.setDate(today.getDate() - 5)

    // grab our data and create our rows
    await fetch("/YOLO/data-processing/get-recent-announcements.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Something went wrong while trying to get announcements.");
            }
            return response.json();
        })
        .then(data => {
            const announcement = document.getElementById('announcements');
            if (!announcement) {
                console.error('Announcements not found in HTML');
                return;
            }
            data.forEach(announcements => {
                let announcement_date = new Date(announcements.date);
                // we shouldn't need to check anything else since we have no feature for future announcements
                if (lastFiveDays <= announcement_date &&
                    announcement_date) {
                    const row = document.createElement('p');

                    // we'll change the format of the dates so it doesn't display the h/m/s
                    let formattedDate = announcement_date.toISOString().split('T')[0];

                    row.innerHTML = `
                       
                            <form id = "${announcements.announcementsId}" method = "POST">
                                <input type = "hidden" name = "announcementId" value = "${announcements.announcementsId}">
                                <a href="javascript:void(0);" onclick="document.getElementById('${announcements.announcementsId}').submit();"><i class="fa-solid fa-bullhorn"></i>
                                ${announcements.title}</a>
                                <p class = "dated">Posted: ${formattedDate}</p>
                            </form>
                       `;
                    announcement.appendChild(row);
                }

            });
        })
        .catch((error) => {
            console.error('Error loading announcements:', error);
        });
}
