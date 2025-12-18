// Add your JS customizations here
window.onload = function() {
  // do something when the page loads
  if(window.location.hash.substring(1)){
    const scrollId = window.location.hash.substring(1);
    dlinqAccordExpand(scrollId);
		dlinqScrollTo(scrollId);
  }
	dlinqSideNav();
	sideLayoutBigMenuFix();
	dlinqAttendance();//what is the problem?
	dlinqEmailButton();//email copy button for events
	dlinqFeedbackButton();//email feedback button for events
	deleteByHumanHand();
	copyAIPrompt();
	dlinqAccordionSearchable();//enable find-in-page for hidden accordions
};

//SMOOTH SCROLL
addEventListener("hashchange", (event) => {
    //alert(window.location.hash.substring(1));
    const scrollId = window.location.hash.substring(1);
    dlinqAccordExpand(scrollId);
	dlinqScrollTo(scrollId);
});
 

function dlinqScrollTo(id){
	const destination = document.getElementById(id);
  destination.scrollIntoView({behavior: 'smooth', block: 'start'});
	
}

// Toggle fixed class for #side-layout-big-menu when it reaches top of viewport
function sideLayoutBigMenuFix() {
	const el = document.getElementById('side-layout-big-menu');
	if (!el) return;

	// Compute element's offsetTop relative to the document
	const getOrigin = () => el.getBoundingClientRect().top + (window.pageYOffset || document.documentElement.scrollTop);
	let originOffsetTop = getOrigin();

	const throttle = (fn, wait = 50) => {
		let last = 0;
		let timeout = null;
		return function(...args) {
			const now = Date.now();
			const run = () => { last = Date.now(); timeout = null; fn.apply(this, args); };
			if (now - last > wait) run(); else if (!timeout) timeout = setTimeout(run, wait - (now - last));
		};
	};

	const check = () => {
		const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
		if (scrollTop >= originOffsetTop) {
			if (!el.classList.contains('dlinq-fixed-top')) el.classList.add('fixed-top', 'dlinq-fixed-top');
		} else {
			el.classList.remove('fixed-top', 'dlinq-fixed-top');
		}
	};

	const recompute = () => {
		originOffsetTop = getOrigin();
		check();
	};

	window.addEventListener('scroll', throttle(check, 40));
	window.addEventListener('resize', throttle(recompute, 150));

	// Run once to initialize state
	recompute();
}

//EXPAND DIV
function dlinqAccordExpand(id){
	const accordion = document.querySelector('#'+id);
	if(accordion.classList.contains('accordion-header')){
		const button = document.querySelector('#'+id+'-button');
		accordion.classList.remove('collapsed');
		accordion.focus();
		button.setAttribute('aria-expanded', 'true');
		const content = document.querySelector('#'+id+'-content');
		content.classList.add('show');
	}
}

//PARTICLES
particlesJS("particles-js", {
	particles: {
		number: { value: 80, density: { enable: true, value_area: 800 } },
		color: { value: "#ffffff" },
		shape: {
			type: "circle",
			stroke: { width: 0, color: "#000000" },
			polygon: { nb_sides: 5 },
			image: { src: "img/github.svg", width: 100, height: 100 },
		},
		opacity: {
			value: 0.5,
			random: false,
			anim: { enable: false, speed: 1, opacity_min: 0.1, sync: false },
		},
		size: {
			value: 3,
			random: true,
			anim: { enable: false, speed: 40, size_min: 0.1, sync: false },
		},
		line_linked: {
			enable: true,
			distance: 150,
			color: "#ffffff",
			opacity: 0.4,
			width: 1,
		},
		move: {
			enable: true,
			speed: .8,
			direction: "none",
			random: false,
			straight: false,
			out_mode: "out",
			bounce: false,
			attract: { enable: false, rotateX: 600, rotateY: 1200 },
		},
	},
	interactivity: {
		detect_on: "canvas",
		events: {
			onhover: { enable: true, mode: "grab" },
			onclick: { enable: true, mode: "push" },
			resize: true,
		},
		modes: {
			grab: { distance: 400, line_linked: { opacity: 1 } },
			bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 },
			repulse: { distance: 200, duration: 0.4 },
			push: { particles_nb: 4 },
			remove: { particles_nb: 2 },
		},
	},
	retina_detect: true,
});


//REGISTRATION ****
function dlinqAttendance(){
	if(document.querySelector('.attend')){
		dlinqShowedUp();
		const attendButtons = document.querySelectorAll('.attend');
		attendButtons.forEach((button) => {
		  button.addEventListener('click', () => {
		    //alert("forEach worked");
		   // alert(button.dataset.state);
		  			jQuery.ajax({
			        type: "POST",
			        url: dlinq_attendance_update.ajax_url,
			        data: {
			            action: 'dlinq_attendance_update',
			            // add your parameters here
			            entry_id: button.dataset.entry,
			      			entry_state: button.dataset.state,
			      			nonce : dlinq_attendance_update.nonce,
			        },
			        success: function (output) {
			           button.classList.toggle('present');//add or remove class
			           button.innerHTML = button.innerHTML == 'No' ? 'Yes' : 'No';//change button text
			           button.dataset.state = button.dataset.state  == 'No' ? 'Yes' : 'No';//change data attribute
			           dlinqShowedUp();
			        }
		        });
		    
		  });
		});
	}
}

function dlinqShowedUp(){
	if(document.querySelectorAll("[data-state='Yes']")){
		const attending = document.querySelectorAll("[data-state='Yes']");
		const displayAttend = document.querySelector("#totalCame");
		displayAttend.innerHTML = attending.length;
	}
}


//turn on tooltips
jQuery(function () {
  jQuery('[data-toggle="tooltip"]').tooltip()
})

//deletion confirmation NEED TO MAKE THIS

//copy all emails

function dlinqEmailButton(){
	if(document.querySelector('#copy-emails')){
		 const copyButton = document.querySelector('#copy-emails');
		 copyButton.addEventListener('click', () => {
		 	dlinqGatherEmails();
		 })
	}
}

function dlinqFeedbackButton() {
	
    const feedbackButton = document.querySelector('#feedback-email');
    if (feedbackButton) {
        //alert('feedback email button found');
        feedbackButton.addEventListener('click', async () => {
            //alert('feedback email button clicked');
            await copyRichText();
        });
    }
}

async function copyRichText() {
    const feedbackElement = document.querySelector('#feedback-message');
    if (!feedbackElement) {
        console.error('Feedback message element not found');
        return;
    }

    const htmlBody = feedbackElement.innerHTML;
    const textBody = feedbackElement.textContent || feedbackElement.innerText;

    try {
        const htmlBlob = new Blob([htmlBody], { type: 'text/html' });
        const textBlob = new Blob([textBody], { type: 'text/plain' });

        const clipboardItem = new ClipboardItem({
            'text/html': htmlBlob,
            'text/plain': textBlob
        });

        await navigator.clipboard.write([clipboardItem]);
        alert('HTML content copied to clipboard!');
    } catch (err) {
        console.error('Failed to copy content:', err);
    }
}

function dlinqGatherEmails(){
	let allEmails = [];
	const regListItems = document.querySelectorAll('.reg-list li');
	regListItems.forEach((reg)=>{
		const email = reg.dataset.email;
		allEmails.push(email);
	})
	const cleanEmails = allEmails.join("; ");
	navigator.clipboard.writeText(cleanEmails);
	  document.querySelector('#copy-emails').insertAdjacentHTML('afterEnd','<div class="copy-alert">copied</div>')
}


function deleteByHumanHand() {
  if (window.location) {
    const newUrl = new URL(window.location.href);
    const params = new URLSearchParams(newUrl.search);
    let confirmed = false;
    
    if (params.has('delete') && !params.has('confirmed')) {
      confirmed = confirm("Are you sure you want to delete your reservation?");
    }
    
    if (confirmed) {
      params.set("confirmed", "yes");
      newUrl.search = params.toString();
      window.location.replace(newUrl);
      alert('Thank you for confirming the deletion.');
    }
  }
}


function copyAIPrompt() {
	// Find all copy buttons. Use querySelectorAll (returns NodeList with forEach)
	const copyButtons = document.querySelectorAll('.copy-button');
	//alert('copyAIPrompt function loaded');
	if (!copyButtons || copyButtons.length === 0) return;

	copyButtons.forEach(button => {
		button.addEventListener('click', async () => {
			//alert('copy button clicked');
			const promptId = button.dataset.id;
			const promptElement = document.getElementById(`prompt-box-${promptId}`);
			if (!promptElement) {
				return;
			}

			const promptText = promptElement.innerText || promptElement.textContent || '';
			try {
				await navigator.clipboard.writeText(promptText);
				// Insert a temporary copied indicator and remove it after 2s
				const alertEl = document.createElement('div');
				alertEl.className = 'copy-alert';
				alertEl.textContent = 'copied';
				button.insertAdjacentElement('afterend', alertEl);
				setTimeout(() => alertEl.remove(), 4000);
			} catch (err) {
				console.error('copyAIPrompt: failed to copy to clipboard', err);
			}
		});
	});
}

// Enable find-in-page (Ctrl+F) for hidden accordion content
function dlinqAccordionSearchable() {
	// Find all accordion collapse elements
	document.querySelectorAll('.accordion-collapse').forEach(collapseElement => {

		// Listen for beforematch event (browser find-in-page)
		collapseElement.addEventListener('beforematch', (event) => {
			// Remove hidden attribute to reveal content
			collapseElement.removeAttribute('hidden');

			// Add Bootstrap's show class to display it properly
			collapseElement.classList.add('show');

			// Update the button to reflect open state
			const button = document.querySelector(`[data-bs-target="#${collapseElement.id}"]`);
			if (button) {
				button.classList.remove('collapsed');
				button.setAttribute('aria-expanded', 'true');
			}
		});

		// Listen to Bootstrap's show.bs.collapse event (user clicks to open)
		collapseElement.addEventListener('show.bs.collapse', () => {
			// Remove hidden attribute when opening
			collapseElement.removeAttribute('hidden');
		});

		// Listen to Bootstrap's hidden.bs.collapse event (user clicks to close)
		collapseElement.addEventListener('hidden.bs.collapse', () => {
			// Add hidden=until-found back when closed
			collapseElement.setAttribute('hidden', 'until-found');
		});
	});
}

// Side nav: mark corresponding link active when its section scrolls into view
function dlinqSideNav() {
	// Handle ALL side-nav menus on the page, not just the first one
	const sideNavs = document.querySelectorAll('.dlinq-side-nav');
	if (sideNavs.length === 0) return;

	sideNavs.forEach(sideNav => {
		const links = Array.from(sideNav.querySelectorAll('a[href^="#"], a[data-content]'));
		if (links.length === 0) return;

		const idToLink = new Map();
		const targets = [];

		links.forEach(link => {
			// support href="#id" or data-content="id"
			const dataId = link.dataset && link.dataset.content ? link.dataset.content : null;
			const href = link.getAttribute('href');
			const hrefId = href && href.startsWith('#') ? decodeURIComponent(href.slice(1)) : null;
			const id = dataId || hrefId;
			if (!id) return;

			const el = document.getElementById(id);
			if (el) {
				idToLink.set(id, link);
				targets.push(el);
			}

			// clicking a link should set it active immediately and smooth-scroll to target
			link.addEventListener('click', (e) => {
				e.preventDefault();
				links.forEach(l => l.classList.toggle('active', l === link));
				const targetEl = document.getElementById(id);
				if (targetEl) {
					// Scroll with 80px top padding
					const targetRect = targetEl.getBoundingClientRect();
					const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
					const targetTop = scrollTop + targetRect.top - 80;
					window.scrollTo({
						top: targetTop,
						behavior: 'smooth'
					});
				}
			});
		});

		function setActiveById(id) {
			const link = idToLink.get(id);
			if (!link) return;
			// Remove active from ALL side-nav links on the page
			document.querySelectorAll('.dlinq-side-nav .nav-link').forEach(l => l.classList.remove('active'));
			// Then add to the target link
			link.classList.add('active');
		}

		// Use a robust scroll-based checker (works consistently across browsers)
		const throttle = (fn, wait) => {
			let last = 0;
			let timeout = null;
			return function(...args) {
				const now = Date.now();
				const run = () => { last = Date.now(); timeout = null; fn.apply(this, args); };
				if (now - last > wait) {
					run();
				} else if (!timeout) {
					timeout = setTimeout(run, wait - (now - last));
				}
			};
		};

		const getActiveCandidate = () => {
			// Reference point: 20% down from top of viewport
			const ref = window.innerHeight * 0.2;
			let best = null;
			let bestDistance = Infinity;

			targets.forEach(t => {
				const rect = t.getBoundingClientRect();
				// consider elements that are not fully below the fold
				const distance = Math.abs(rect.top - ref);
				if (rect.bottom >= 0 && rect.top <= window.innerHeight) {
					if (distance < bestDistance) {
						bestDistance = distance;
						best = t;
					}
				}
			});

			return best;
		};

		const updateActiveFromScroll = () => {
			const candidate = getActiveCandidate();
			if (candidate) setActiveById(candidate.id);
		};

		// IntersectionObserver can be a lightweight helper to catch fast jumps
		if ('IntersectionObserver' in window) {
			const observer = new IntersectionObserver((entries) => {
				// when a section intersects, pick the candidate using the same heuristic
				const candidate = getActiveCandidate();
				if (candidate) setActiveById(candidate.id);
			}, { root: null, rootMargin: '0px 0px -60% 0px', threshold: 0 });

			targets.forEach(t => observer.observe(t));
		}

		// Always attach a throttled scroll handler for reliable updates
		window.addEventListener('scroll', throttle(updateActiveFromScroll, 120));
		window.addEventListener('resize', throttle(updateActiveFromScroll, 200));
		// run once to set initial state
		updateActiveFromScroll();

		// If a hash is present on load, mark that link active
		if (window.location.hash) {
			const id = decodeURIComponent(window.location.hash.slice(1));
			setActiveById(id);
		}
	});
}