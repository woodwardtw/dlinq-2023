// Side Nav Content Switching Functionality
// Based on CodePen example - switches content within sections

function dlinqSideNavContentSwitcher() {
  // Use event delegation on document so it works for all menus, even dynamic ones
  document.addEventListener('click', e => {
    const link = e.target.closest('.dlinq-side-nav .nav-link[data-content]');
    if (!link) return;

    e.preventDefault();

    // Get the section containing this sidebar
    const section = link.closest('section');
    if (!section) return;

    const nav = section.querySelector('.dlinq-side-nav');
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

    // Update active state on sidebar links within THIS SECTION'S NAV ONLY
    if (nav) {
      nav.querySelectorAll('.nav-link').forEach(l => {
        l.classList.remove('active');
      });
    }
    link.classList.add('active');
  }, true); // Use capture phase for better delegation

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
