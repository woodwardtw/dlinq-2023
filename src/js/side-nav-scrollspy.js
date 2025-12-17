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

    // Scroll to selected content with 80px top padding
    const targetContent = contentArea.querySelector(`#${contentId}`);
    if (targetContent) {
      const targetRect = targetContent.getBoundingClientRect();
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      const targetTop = scrollTop + targetRect.top - 80; // 80px padding from top
      window.scrollTo({
        top: targetTop,
        behavior: 'smooth'
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

  // Handle hash navigation for direct links to sections with 80px top padding
  if (window.location.hash) {
    setTimeout(() => {
      const sectionId = window.location.hash.substring(1);
      const section = document.getElementById(sectionId);
      if (section) {
        const sectionRect = section.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const sectionTop = scrollTop + sectionRect.top - 80; // 80px padding from top
        window.scrollTo({
          top: sectionTop,
          behavior: 'smooth'
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
