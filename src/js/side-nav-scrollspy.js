// Side Nav Content Switching Functionality
// Based on CodePen example - switches content within sections

function dlinqSideNavContentSwitcher() {
  // Handle sidebar navigation clicks
  document.querySelectorAll('.dlinq-side-nav .nav-link[data-content]').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();

      // Get the section containing this sidebar
      const section = link.closest('section');
      if (!section) return;

      const contentArea = section.querySelector('.content-area');
      if (!contentArea) return;

      const contentId = link.getAttribute('data-content');

      // Scroll to selected content
      const targetContent = contentArea.querySelector(`#${contentId}`);
      if (targetContent) {
        targetContent.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }

      // Update active state on sidebar links within this section
      section.querySelectorAll('.dlinq-side-nav .nav-link').forEach(l => {
        l.classList.remove('active');
      });
      link.classList.add('active');
    });
  });

  // Set first item in each section as active by default
  document.querySelectorAll('section').forEach(section => {
    const firstLink = section.querySelector('.dlinq-side-nav .nav-link[data-content]');
    if (firstLink) {
      firstLink.classList.add('active');
    }
  });

  // Handle hash navigation for direct links to sections
  if (window.location.hash) {
    setTimeout(() => {
      const sectionId = window.location.hash.substring(1);
      const section = document.getElementById(sectionId);
      if (section) {
        section.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    }, 100);
  }
}

// Initialize on page load
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', dlinqSideNavContentSwitcher);
} else {
  dlinqSideNavContentSwitcher();
}
