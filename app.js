barba.init({
    transitions: [
      {
        name: "fade",
        
        once({ current, next, trigger }) {
          let tl = gsap.timeline();
          tl.to(".cover span", {
            y: "-100%",
            stagger: 0.1
          });
          tl.to(".cover", {
            y: "-100%",
            opacity: 0,
          });
          tl.from(".home-image", {
            x: "-100%", // Start from the left (-100%)
            opacity: 0,
            duration: 1, // Adjust duration as needed
          });
          tl.from(".bigcard", {
            x: "-100%", // Start from the left (-100%)
            opacity: 0,
            duration: 0.5, // Adjust duration as needed
          });
          tl.from("h1 span", {
            y: 100,
            stagger: 0.2,
            opacity: 0,
          });
          return tl;
        },
        leave({ current, next, trigger }) {
          let tl = gsap.timeline();
          tl.to(".cover span", {
            y: "0%",
            stagger: 0.1
          });
          tl.to(".cover", {
            y: "0%",
            opacity: 0,
          });
          return tl;
        },
        beforeEnter({ current, next, trigger }) {
          gsap.set(current.container, {
            display: "none",
          });
        },
        enter({ current, next, trigger }) {
          let tl = gsap.timeline();
          tl.to(".cover span", {
            y: "-100%",
            stagger: 0.1
          });
          tl.to(".cover", {
            y: "-100%",
            opacity: 0,
          });
          tl.from(".home-image", {
            x: "-100%",
            opacity: 0,
            duration: 1, 
          });
          tl.from("h1 span", {
            y: 100,
            stagger: 0.2,
            opacity: 0,
          });
          tl.from(".bigcard", {
            x: "-100%", 
            opacity: 0,
            duration: 0.5,
          });
          return tl;
        },
      },
    ],
  });
  