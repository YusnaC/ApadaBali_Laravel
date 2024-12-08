import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded and parsed");

    const deleteButtons = document.querySelectorAll(".btn-delete");
    console.log(`Found ${deleteButtons.length} delete buttons`);

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            console.log("Delete button clicked");

            const projectId = this.getAttribute("data-id");
            console.log(`Project ID: ${projectId}`);

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        console.log("Confirmed deletion");

                        fetch(`/projects/${projectId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                            },
                        })
                            .then((response) => {
                                if (response.ok) {
                                    swalWithBootstrapButtons
                                        .fire(
                                            "Deleted!",
                                            "Your file has been deleted.",
                                            "success"
                                        )
                                        .then(() => {
                                            location.reload();
                                        });
                                } else {
                                    console.error("Failed to delete");
                                    swalWithBootstrapButtons.fire(
                                        "Error",
                                        "Failed to delete the file.",
                                        "error"
                                    );
                                }
                            })
                            .catch((error) => {
                                console.error("Fetch error:", error);
                                swalWithBootstrapButtons.fire(
                                    "Error",
                                    "Something went wrong.",
                                    "error"
                                );
                            });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        console.log("Deletion cancelled");
                        swalWithBootstrapButtons.fire(
                            "Cancelled",
                            "Your imaginary file is safe :)",
                            "error"
                        );
                    }
                });
        });
    });
});
