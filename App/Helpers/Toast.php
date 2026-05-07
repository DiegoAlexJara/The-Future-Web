<?php


function showToast()
{
    if (!isset($_SESSION['toast'])) {
        return;
    }

    $toast = $_SESSION['toast'];
    $status = $toast['status'];
    $message = $toast['message'];

    // limpiar para que no se repita
    unset($_SESSION['toast']);

    // Renderizar HTML + JS
    echo '
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div id="liveToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">' . $message . '</div>
          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const toastEl = document.getElementById("liveToast");
        if ("' . $status . '" === "success") {
          toastEl.classList.add("text-bg-success");
        } else {
          toastEl.classList.add("text-bg-danger");
        }
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
      });
    </script>
    ';
}
