document.querySelectorAll(".btnDelete").forEach(button => {
    button.addEventListener("click", function () {
        const userId = this.dataset.id;
        const form = document.getElementById("deleteForm-" + userId);

        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // envía el formulario correcto
            }
        });
    });
});