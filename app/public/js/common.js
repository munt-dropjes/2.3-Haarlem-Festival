// common.js

function openTab(tabName) {
    const tabcontent = document.querySelectorAll(".yummieDetail-tabcontent");
    const tabbuttons = document.querySelectorAll(".yummieDetail-tab-button");

    tabcontent.forEach(tab => {
        tab.style.display = "none";
    });

    tabbuttons.forEach(button => {
        button.classList.remove("active");
    });

    const activeContent = document.getElementById(tabName);
    if (activeContent) {
        activeContent.style.display = "block";
    }

    const activeButton = document.querySelector(`.yummieDetail-tab-button[data-tab="${tabName}"]`);
    if (activeButton) {
        activeButton.classList.add("active");
    }
}
