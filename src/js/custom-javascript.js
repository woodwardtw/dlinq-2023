// Add your JS customizations here
window.onload = function() {
  // do something when the page loads
  if(window.location.hash.substring(1)){
    const scrollId = window.location.hash.substring(1);
    dlinqAccordExpand(scrollId);
		dlinqScrollTo(scrollId);
  }	
	dlinqAttendance();//what is the problem?
	dlinqEmailButton();//email copy button for events
	dlinqFeedbackButton();//email feedback button for events
	deleteByHumanHand();
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