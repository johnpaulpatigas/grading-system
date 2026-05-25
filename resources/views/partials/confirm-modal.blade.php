<div id="confirm-modal" class="fixed inset-0 z-[200] flex items-center justify-center bg-gray-900/50 hidden" onclick="closeConfirmModal()">
    <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-sm" onclick="event.stopPropagation()">
        <h3 class="text-lg font-bold text-gray-900" id="confirm-title">Are you sure?</h3>
        <p class="text-sm text-gray-500 mt-2" id="confirm-message">This action cannot be undone.</p>
        <div class="mt-6 flex justify-end gap-3">
            <button onclick="closeConfirmModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
            <button id="confirm-action" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Confirm</button>
        </div>
    </div>
</div>

<script>
    let formToSubmit = null;

    function showConfirmModal(message, title, form) {
        document.getElementById('confirm-message').innerText = message;
        if (title) document.getElementById('confirm-title').innerText = title;
        formToSubmit = form;
        document.getElementById('confirm-modal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirm-modal').classList.add('hidden');
        formToSubmit = null;
    }

    document.getElementById('confirm-action').addEventListener('click', () => {
        if (formToSubmit) formToSubmit.submit();
        closeConfirmModal();
    });
</script>
