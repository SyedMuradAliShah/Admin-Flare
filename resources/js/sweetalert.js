import Swal from "sweetalert2/dist/sweetalert2.min.js";

document.addEventListener("livewire:init", function () {
    document.addEventListener("livewire:navigated", () => {
        document.querySelectorAll(".delete").forEach(function (deleteButton) {
            deleteButton.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                const method = this.getAttribute("data-method") || "delete";
                const title =
                    this.getAttribute("data-title") || "Are you sure?";
                const text =
                    this.getAttribute("data-text") ||
                    "Do you want to delete this item?";
                const buttonText =
                    this.getAttribute("data-button-text") || "Yes, delete it!";
                const cancelTitle =
                    this.getAttribute("data-cancel-title") || "Cancelled";
                const cancelText =
                    this.getAttribute("data-cancel-text") ||
                    "Your action was cancelled.";

                Livewire.dispatch("swal:confirm", [
                    {
                        title: title,
                        text: text,
                        icon: "warning",
                        confirmButtonText: buttonText,
                        cancelTitle: cancelTitle,
                        cancelText: cancelText,
                        method: method,
                        data: {
                            id: id,
                        },
                    },
                ]);
            });
        });

        // Sweet Confirm Modal
        Livewire.on("swal:confirm", (e) => {
            Swal.fire({
                title: e[0].title || "Are you sure?",
                text: e[0].text || "You won't be able to revert this!",
                icon: e[0].icon || "warning",
                showCancelButton: true,
                confirmButtonText: e[0].confirmButtonText || "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Please wait",
                        text: "Processing your request...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                    Livewire.dispatch(e[0].method, e[0].data);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Action cancelled, do nothing or show a canceled message
                    Swal.fire({
                        title: e[0].cancelTitle || "Cancelled",
                        text: e[0].cancelText || "Your action was cancelled.",
                        icon: e[0].cancelIcon || "info",
                    });
                }
            });
        });

        // Sweet Modal
        Livewire.on("swal:alert", (e) => {
            Swal.fire({
                icon: e[0].icon || "error",
                title: e[0].title || "Unexpected Error",
                text: e[0].text || "",
                timer: e[0].timer || null, // Add a timer if provided
                showConfirmButton: e[0].confirmButton ?? true, // Default is true unless specified
                timerProgressBar: e[0].bar ?? false, // Progress bar for timer
                didOpen: (modal) => {
                    modal.addEventListener("mouseenter", Swal.stopTimer);
                    modal.addEventListener("mouseleave", Swal.resumeTimer);
                },
            }).then((result) => {
                if (
                    result.isConfirmed ||
                    result.dismiss === Swal.DismissReason.timer
                ) {
                    if (e[0].url) {
                        Livewire.navigate(e[0].url, {
                            replace: e[0].replace ?? false,
                        });
                    }

                    e[0].reload && window.location.reload();
                }

                e[0].modal && $(e[0].modal).modal("hide");
            });
        });

        // Sweet Toast
        Livewire.on("swal:toast", (e) => {
            Swal.fire({
                toast: true, // Enable toast
                position: e[0].position || "top-end", // Toast position (default to top-end)
                icon: e[0].icon || "success", // Default icon (can be success, error, etc.)
                title: e[0].title || "Success", // The toast title
                showConfirmButton: false, // No confirmation button for toasts
                timer: e[0].timer || 3000, // Auto-dismiss after the specified time (default 3 seconds)
                timerProgressBar: e[0].bar ?? true, // Show a progress bar
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer); // Pause on hover
                    toast.addEventListener("mouseleave", Swal.resumeTimer); // Resume on mouse leave
                },
            });
        });
    });
});
