import $ from "jquery";
import bootstrap from "bootstrap/dist/js/bootstrap.bundle.min.js";

document.addEventListener("livewire:init", function () {
    document.addEventListener("livewire:navigated", () => {

        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const lightModeIcon = document.querySelector(".light-mode");
        const darkModeIcon = document.querySelector(".dark-mode");

        // Function to update theme icons visibility using show() and hide() equivalent
        const updateIcons = (isDarkMode) => {
            if (isDarkMode) {
                lightModeIcon.style.display = "none"; // Hide moon icon in dark mode
                darkModeIcon.style.display = "block"; // Show sun icon in dark mode
            } else {
                lightModeIcon.style.display = "block"; // Show moon icon in light mode
                darkModeIcon.style.display = "none"; // Hide sun icon in light mode
            }
        };

        // Function to auto check theme based on user or system preference
        const autoCheckTheme = () => {
            let userTheme = localStorage.getItem("theme");
            const systemTheme = window.matchMedia(
                "(prefers-color-scheme: dark)"
            ).matches;

            const isDarkMode =
                userTheme === "dark" || (!userTheme && systemTheme);
            document.documentElement.setAttribute(
                "data-bs-theme",
                isDarkMode ? "dark" : "light"
            );
            updateIcons(isDarkMode);
        };

        // Function to switch between dark and light modes
        const switchTheme = (mode) => {
            document.documentElement.setAttribute("data-bs-theme", mode);
            localStorage.setItem("theme", mode);
            updateIcons(mode === "dark");
        };

        // Initialize theme on page load
        autoCheckTheme();

        // Add event listeners for the mode icons
        if (lightModeIcon) {
            lightModeIcon.addEventListener("click", function () {
                switchTheme("dark");
            });
        }

        if (darkModeIcon) {
            darkModeIcon.addEventListener("click", function () {
                switchTheme("light");
            });
        }

        $("[data-password]").click(function () {
            const input = $(this).siblings("input");
            const eyeIcon = $(this).find(".fa-eye");
            const eyeSlashIcon = $(this).find(".fa-eye-slash");

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                eyeIcon.hide();
                eyeSlashIcon.show();
            } else {
                input.attr("type", "password");
                eyeSlashIcon.hide();
                eyeIcon.show();
            }
        });

        // const eyeIconContainer = document.querySelector('.eye-icon');
        // const passwordInput = document.getElementById('password');

        // if (eyeIconContainer && passwordInput) {
        //     eyeIconContainer.addEventListener('click', function () {
        //         const eyeIcon = eyeIconContainer.querySelector('#fa-eye');
        //         const eyeSlashIcon = eyeIconContainer.querySelector('#fa-eye-slash');

        //         if (passwordInput.type === 'password') {
        //             // Show password
        //             passwordInput.type = 'text';
        //             eyeIcon.style.display = 'none'; // Hide eye icon
        //             eyeSlashIcon.style.display = 'block'; // Show eye-slash icon
        //         } else {
        //             // Hide password
        //             passwordInput.type = 'password';
        //             eyeIcon.style.display = 'block'; // Show eye icon
        //             eyeSlashIcon.style.display = 'none'; // Hide eye-slash icon
        //         }
        //     });
        // }

        // Sidebar toggle button
        const toggleButton = document.getElementById("toggle-button");
        const sidebar = document.getElementById("sidebar");

        if (toggleButton && sidebar) {
            toggleButton.addEventListener("click", function () {
                sidebar.classList.toggle("open");
            });
        }

        // Sidebar close button
        const closeButton = document.getElementById("close-button");

        if (closeButton && sidebar) {
            closeButton.addEventListener("click", function () {
                sidebar.classList.remove("open"); // Remove the 'open' class to close the sidebar
            });
        }

        // Sidebar dropdown toggle
        const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

        if (dropdownToggles.length > 0) {
            dropdownToggles.forEach(function (toggle) {
                toggle.addEventListener("click", function () {
                    const dropdown = this.parentElement;

                    // Close all other open dropdowns
                    document
                        .querySelectorAll(".dropdown.open")
                        .forEach(function (openDropdown) {
                            if (openDropdown !== dropdown) {
                                openDropdown.classList.remove("open");
                            }
                        });

                    // Toggle the clicked dropdown
                    dropdown.classList.toggle("open");
                });
            });
        }
    });
});
if (typeof ApexCharts !== "undefined") {
    // charts
    var options = {
        series: [
            {
                name: "series1",
                data: [31, 40, 28, 51, 42, 109, 100],
            },
        ],
        chart: {
            height: 350,
            type: "area",
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: "smooth",
        },
        xaxis: {
            type: "datetime",
            categories: [
                "2018-09-19T00:00:00.000Z",
                "2018-09-19T01:30:00.000Z",
                "2018-09-19T02:30:00.000Z",
                "2018-09-19T03:30:00.000Z",
                "2018-09-19T04:30:00.000Z",
                "2018-09-19T05:30:00.000Z",
                "2018-09-19T06:30:00.000Z",
            ],
        },
        tooltip: {
            x: {
                format: "dd/MM/yy HH:mm",
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    // charts
    // donutcharts
    var options = {
        series: [44, 55, 41, 17, 15],
        chart: {
            type: "donut",
        },
        labels: ["Label 1", "Label 2", "Label 3", "Label 4", "Label 5"], // Labels are required but will be hidden
        dataLabels: {
            enabled: false, // Hides data labels from the chart itself
        },
        legend: {
            show: false, // Hides the legend
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200,
                    },
                },
            },
        ],
    };

    var chart = new ApexCharts(document.querySelector("#donutchart"), options);
    chart.render();
    // donutcharts
}
