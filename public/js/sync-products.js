document.addEventListener("DOMContentLoaded", () => {
    const syncButton = document.getElementById("sync-products");

    if (!syncButton) {
        return;
    }

    const messageContainer = document.createElement("div");
    messageContainer.classList.add("mt-3");
    syncButton.parentNode?.appendChild(messageContainer);

    syncButton.addEventListener("click", async () => {
        const url = syncButton.dataset.syncUrl;
        const limit = Number.parseInt(syncButton.dataset.syncLimit, 10) || 10;
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        syncButton.disabled = true;
        syncButton.textContent = "Syncing...";
        messageContainer.innerHTML = "";

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ limit }),
            });

            if (!response.ok) {
                throw new Error("Failed to sync products");
            }

            const data = await response.json();
            const syncedCount = Array.isArray(data.data) ? data.data.length : 0;
            messageContainer.innerHTML = `<div class="alert alert-success mt-3">Synced ${syncedCount} products successfully.</div>`;

            setTimeout(() => {
                window.location.reload();
            }, 600);
        } catch (error) {
            console.error(error);
            messageContainer.innerHTML =
                '<div class="alert alert-danger mt-3">Unable to sync products. Please try again.</div>';
        } finally {
            syncButton.disabled = false;
            syncButton.textContent = "Sync Products";
        }
    });
});
