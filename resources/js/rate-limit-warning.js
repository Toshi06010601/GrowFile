document.addEventListener("livewire:init", () => {
    Livewire.hook("request", ({ fail }) => {
        fail(({ status, content, preventDefault }) => {
            if (status === 429) {
                preventDefault();

                const data = JSON.parse(content);
                const retryAfter = data?.retry_after || 200;
                const message = data?.message || "Too many requests.";

                Swal.fire({
                    icon: "warning",
                    title: "Rate Limit Exceeded",
                    html: `
                        <p>${message}</p>
                        <p class="text-sm text-gray-600 mt-2">
                            You can try again in <strong>${retryAfter}</strong> seconds.
                        </p>
                    `,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: retryAfter * 1000,
                });
            }
        });
    });
});
