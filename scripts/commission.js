// ============================================================================
// COMMISSION FORM CONTROLLER: Multi-select Chips & Smooth Submission
// ============================================================================

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    const chips = document.querySelectorAll('.c-service-chip');
    const selectedNeeds = new Set();
    const form = document.getElementById('commissionForm');

    // Multi-select chip toggling
    chips.forEach(chip => {
      chip.addEventListener('click', (e) => {
        e.preventDefault();
        chip.classList.toggle('active');
        const isSelected = chip.classList.contains('active');
        const val = chip.textContent.trim();

        if (isSelected) {
          selectedNeeds.add(val);
          chip.style.background = '#111';
          chip.style.color = '#fff';
          chip.style.borderColor = '#111';
        } else {
          selectedNeeds.delete(val);
          chip.style.background = '';
          chip.style.color = '';
          chip.style.borderColor = '';
        }
      });
    });

    // Form submission
    if (form) {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const nameInput = document.getElementById('commName');
        const emailInput = document.getElementById('commEmail');
        const name = nameInput?.value.trim() || 'Client';
        const email = emailInput?.value.trim() || 'your email';
        const needs = Array.from(selectedNeeds).join(', ') || 'Custom Project';

        // Create or show beautiful confirmation banner
        let successBox = document.getElementById('commSuccessBox');
        if (!successBox) {
          successBox = document.createElement('div');
          successBox.id = 'commSuccessBox';
          successBox.style.cssText = 'background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 16px; padding: 24px; margin-top: 24px; text-align: center; color: #166534; box-shadow: 0 4px 16px rgba(0,0,0,0.04);';
          form.parentNode.insertBefore(successBox, form.nextSibling);
        }

        successBox.innerHTML = `
          <div style="font-size: 28px; margin-bottom: 8px;">✨</div>
          <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px; color: #15803d;">Enquiry Sent Successfully!</h3>
          <p style="font-size: 15px; line-height: 1.6; margin-bottom: 12px; color: #166534;">
            Thank you, <b>${name}</b>. Your commission request for <b>${needs}</b> has been received. Nana will review your brief and reply to <b>${email}</b> with concept ideas and a quote shortly.
          </p>
          <span style="font-size: 13px; color: #15803d; opacity: 0.85;">Expected turnaround: 24–48 hours.</span>
        `;
        successBox.style.display = 'block';
        successBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        form.reset();
        chips.forEach(c => {
          c.classList.remove('active');
          c.style.background = '';
          c.style.color = '';
          c.style.borderColor = '';
        });
        selectedNeeds.clear();
      });
    }
  });
})();
