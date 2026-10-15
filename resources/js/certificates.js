import { Modal } from 'bootstrap';

const initializeCertificateModal = () => {
    const modalElement = document.getElementById('certificateModal');
    const form = document.getElementById('certificateForm');
    const certificateType = document.getElementById('certificateType');
    const printButton = document.getElementById('printCertificateButton');
    const patientSummary = document.getElementById('selectedPatientSummary');

    if (
        !(modalElement instanceof HTMLElement) ||
        !(form instanceof HTMLFormElement) ||
        !(certificateType instanceof HTMLSelectElement) ||
        !(printButton instanceof HTMLButtonElement) ||
        !(patientSummary instanceof HTMLElement)
    ) {
        return;
    }

    const modal = new Modal(modalElement);

    const updateCertificateFields = () => {
        const hasType = certificateType.value !== '';
        printButton.disabled = !hasType;

        document.querySelectorAll('.certificate-fields').forEach(fieldset => {
            if (!(fieldset instanceof HTMLFieldSetElement)) {
                return;
            }

            const isActive = fieldset.dataset.certificateType === certificateType.value;
            fieldset.disabled = !isActive;
            fieldset.classList.toggle('d-none', !isActive);
        });
    };

    document.querySelectorAll('.certificate-patient-select').forEach(button => {
        if (!(button instanceof HTMLButtonElement)) {
            return;
        }

        button.addEventListener('click', () => {
            const patientId = button.dataset.patientId;
            const patientName = button.dataset.patientName;
            const patientCase = button.dataset.patientCase;

            if (!patientId || !patientName || !patientCase) {
                return;
            }

            form.reset();
            patientSummary.textContent = `${patientName} · Case ${patientCase}`;
            form.action = form.dataset.printUrlTemplate.replace(
                '__PATIENT_ID__',
                encodeURIComponent(patientId)
            );
            updateCertificateFields();
            modal.show();
        });
    });

    certificateType.addEventListener('change', updateCertificateFields);

    const selectedPatientId = modalElement.dataset.selectedPatientId;
    if (selectedPatientId) {
        const selectedPatient = Array.from(
            document.querySelectorAll('.certificate-patient-select')
        ).find(button => button instanceof HTMLButtonElement &&
            button.dataset.patientId === selectedPatientId);

        selectedPatient?.click();
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCertificateModal, { once: true });
} else {
    initializeCertificateModal();
}
